<?php

namespace App\Http\Controllers;

use App\HeaderRoomTransaction;
use App\QrModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    //
    public function updateDb(Request $req){
        $header = HeaderRoomTransaction::where("roomTransactionID",$req->data)->first();
        if($header){
            if($header->transactionStatus === "Taken" && Carbon::now()->diffInSeconds($header->updated_at) < 1795){
                $header->transactionStatus = "Done";
                $header->save();
            }else if($header->transactionStatus === "Registered"){
                $header->transactionStatus = "Taken";
                $header->save();
            }
            return response()->json(["message"=>"Transaction Updated","status"=>$header->transactionStatus,"color"=>"green"]);
        }else{
            return response()->json(["message"=>"Transaction Not Found","color"=>"red"]);
        }

    }

    public function a(Request $req){
        $a = QrModel::where("Qrpassword",$req->data)->first();

        if($a !== null){
            return response()->json([
                "Id"=>$a,
                "status" =>true,
            ]);
        }
        
        $qr = new QrModel();
        $qr->Qrpassword = $req->data;
        $qr->save();

        return response()->json([
            "Id"=>$qr,
            "status" =>false,
        ]);
    }
}
