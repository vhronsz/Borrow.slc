<?php

namespace App\Http\Controllers;

use App\DetailRoomTransaction;
use App\HeaderRoomTransaction;
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

            if($req->internetRequest){
                $detail->internetRequest = true;
                $detail->reason = $req->reason;
            }
            $detail->save();

            $qrCode = QrCode::size(300)->generate($header->roomTransactionID);
            return redirect("/view/Home");
    }

}
