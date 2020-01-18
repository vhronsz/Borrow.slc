<?php

namespace App\Http\Controllers;

use App\DetailRoomTransaction;
use App\HeaderRoomTransaction;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionController extends Controller
{
    //
    public  function addRoom(Request $req){

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
        $qrCode = QrCode::size(300)->generate($header->roomTransactionID);
        return redirect("/view/Home")->with("qr",$qrCode);
    }

    public function updateDb(Request $req){
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

}
