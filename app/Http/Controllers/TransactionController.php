<?php

namespace App\Http\Controllers;

use App\DetailRoomTransaction;
use App\HeaderItemTransaction;
use App\HeaderRoomTransaction;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionController extends Controller
{
    //  /*
    //         *
    //         * $table->uuid('roomTransactionID');
    //            $table->uuid('adminID');
    //            $table->dateTime('transactionDate');
    //            $table->string("transactionStatus");
    //            $table->string("campus");
    //            $table->string('roomID');
    //
    //            $table->uuid('roomTransactionID');
    //            $table->integer('shiftStart');
    //            $table->integer('shiftEnd');
    //            $table->boolean('internetRequest');
    //            $table->string('internetReason')->nullable(true);
    //            $table->string('assistant')->nullable(true);
    //            $table->string('borrower');
    //            $table->string("borrowReason");
    //         * */
    public  function addRoom(Request $req){

        $valid = Validator::make($req->all(),[
            "name" => "required",
            "email" => "required",
            "phone" => "required",
            "room" => "required",
            "shiftStart" => "required",
            "shiftEnd" => "required",
            "date" => "required",
            "borrowReason" =>"required",
            "division" => "required"
        ]);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }else {

            $checkHeader =  HeaderRoomTransaction::where("transactionDate", $req->date)->get();

            if ($req->shiftStart > $req->shiftEnd) {
                return redirect()->back()->withErrors("Shift Start Cannot Exceed Shift End");
            }
            foreach ($checkHeader as $header){
                if ($req->shiftStart === $header->shiftStart ||
                    $req->shiftStart === $header->shiftEnd     ||
                    $req->shiftStart >= $header->shiftStart &&
                    $req->shiftStart >= $header->shiftEnd ||
                    $req->shiftEnd === $header->shiftStart
                ){
                    return redirect()->back()->withErrors("There is another transaction in selected shift");
                }
            }
            //New Controller
            $header = new HeaderRoomTransaction();
            $header->roomTransactionID = Uuid::uuid();
            $header->adminID = Uuid::uuid();

            $header->transactionStatus = "Registered";
            $header->campus = "ANGGREK";

            $header->borrowerName = $req->name;
            $header->borrowerEmail = $req->email;
            $header->borrowerPhone = $req->phone;
            $header->roomID = $req->room;
            $header->shiftStart = $req->shiftStart;
            $header->shiftEnd = $req->shiftEnd;
            $header->transactionDate = $req->date;
            $header->borrowerDivision = $req->division;
            $header->borrowerReason = $req->borrowReason;


            if ($req->internetRequest === "yes") {
                $validInet = Validator::make($req->all(), [
                    "internetReason" => "required"
                ]);
                if ($validInet->fails()) {
                    return redirect()->back()->withErrors($validInet->errors());
                }
                $header->internetRequest = true;
                $header->reason = $req->reason;
            }


            $header->save();

            return redirect("/view/room/Home");
        }
    }
//cara update dia liat brp shift kalo satu 30 menit pertama kalo dua liat di shift terakhirnya
//
    public function getShift($shift){
        $time = null;
        $time = "12/12/2010";
        if($shift === 1){
            $time = "1/1/1";
        }
        return $time;
    }

    public function updateRoom(Request $req){
        $header = HeaderRoomTransaction::where("roomTransactionID",$req->data)->first();
        if($header){
            if($header->transactionStatus === "Registered"){
                $header->transactionStatus = "Taken";
                $header->save();
            }
            else if($header->transactionStatus === "Taken" && Carbon::now()->diffInSeconds($header->updated_at) > 200){
                $header->transactionStatus = "Done";
                $header->save();
            }
            return response()->json([   "message"=>"Transaction Updated",
                "status"=>$header->transactionStatus,
                "color"=>"green",
                "time"=>Carbon::now()->diffInSeconds($header->updated_at)
            ]);
        }else{
            return response()->json([   "message"=>"Transaction Not Found",
                "color"=>"red","id"=>$req->data
            ]);
        }

    }


    public  function addItemTransaction(Request $req){

        $valid = Validator::make($req->all(),[
            "name" => "required",
            "email" => "required",
            "phone" => "required",
            "room" => "required",
            "shiftStart" => "required",
            "shiftEnd" => "required",
            "date" => "required",
        ]);

        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }
        if($req->shiftStart > $req->shiftEnd){
            return redirect()->back()->withErrors("Shift Start Cannot Exceed Shift End");
        }

        $header = new HeaderRoomTransaction();
        $header->roomTransactionID = Uuid::uuid();

        //Changed When Done////
        $header->adminID = Uuid::uuid();
        //////////////////////

        $header->transactionDate = Date::now();
        $header->transactionStatus = "Registered";
        $header->save();

        $detail = new DetailRoomTransaction();
        $detail->roomTransactionID = $header->roomTransactionID;
        $detail->roomID = $req->room;
        $detail->shiftStart = $req->shiftStart;
        $detail->shiftEnd = $req->shiftEnd;

        if($req->internetRequest === "yes"){
            $validInet = Validator::make($req->all(),[
                "reason" => "required"
            ]);
            if($validInet->fails()){
                return redirect()->back()->withErrors($validInet->errors());
            }
            $detail->internetRequest = true;
            $detail->reason = $req->reason;
        }

        $detail->save();
//        $qrCode = QrCode::size(300)->generate($header->roomTransactionID);
//        return redirect("/view/Home")->with("qr",$qrCode);
        return redirect()->back();
    }

    public function updateItemTransaction(Request $req){

        $header = HeaderItemTransaction::where("itemTransactionID",$req->data)->first();

        if($header){
            if($header->transactionStatus === "Registered"){
                $header->transactionStatus = "Taken";
                $header->save();
            }
            else if($header->transactionStatus === "Taken" && Carbon::now()->diffInSeconds($header->updated_at) > 200){
                $header->transactionStatus = "Done";
                $header->save();
            }
            return response()->json([
                "message"=>"Item Taken",
                "status"=>$header->transactionStatus,
                "color"=>"green",
                "time"=>Carbon::now()->diffInSeconds($header->updated_at)
            ]);
        }else{
            return response()->json([
                "message"=>"Transaction Not Found",
                "color"=>"red","id"=>$req->data
            ]);
        }

    }

    public function getDataFromMessier(){
        dd($this->getShift(1));

        $date = date("m/d/y",time());
//        $date = date('m/d/y',strtotime("10/10/2019"));
        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
        $json = json_decode($url, true);
        $data = $json["Details"];
        $transactionData = [];
        foreach ($data as $d){
            if($d["Campus"] === "ANGGREK"){
                array_push($transactionData,$d);
            }
        }

        dd($transactionData);
        foreach ($transactionData as $tdata){
            $header = new HeaderRoomTransaction();

            $header->roomTransactionID = Uuid::uuid();
            $header->adminID = Uuid::uuid();
            $header->transactionDate = Carbon::now();
            $header->transactionStatus = "Registered";
            $header->save();

            $detail = new DetailRoomTransaction();
            $detail->roomTransactionID = $header->roomTransactionID;
            $detail->roomID = $tdata["Campus"];
            $idx = 0;
            foreach ($tdata["StatusDetails"] as $shift){

            }
//            $detail->shiftStart = ;


        }
    }
}


//
//            $header = new HeaderRoomTransaction();
//            $header->roomTransactionID = Uuid::uuid();
//
//            //Changed When Done////
//            $header->adminID = Uuid::uuid();
//            //////////////////////
//
//            $header->transactionDate = Date::now();
//            $header->transactionStatus = "Registered";
//            $header->save();
//
//
//            $qrCode = QrCode::size(300)->generate($header->roomTransactionID);
//            return redirect("/view/Home")->with("qr", $qrCode);

