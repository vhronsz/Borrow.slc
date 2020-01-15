<?php

namespace App\Http\Controllers;

use App\QrModel;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    //
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
