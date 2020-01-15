<?php

namespace App\Http\Controllers;

use App\DetailRoomTransaction;
use App\HeaderRoomTransaction;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    //
    public  function add(Request $req){
            $valid = Validator::make($req->all(),[
                "name" => "required",
                "email" => "required",
                "phone" => "required",
                "room" => "required",
                "shiftStart" => "required",
                "shiftEnd" => "required",
                "date" => "required",
            ]);
            $header = new HeaderRoomTransaction();
            $header->roomTransactionID = Uuid::uuid();

            //Changed When Done////
                $header->adminID = Uuid::uuid();
            //////////////////////

            $header->transactionDate = Date::now();
            $header->transactionStatus = "Not Taken";
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
            return redirect()->back();
    }

}
