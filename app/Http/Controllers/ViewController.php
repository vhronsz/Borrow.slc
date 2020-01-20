<?php

namespace App\Http\Controllers;

use App\DetailRoomTransaction;
use App\HeaderRoomTransaction;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    //

    //View and Room
    //Kalo ada tanggal cari transaksi sesuai tanggal , jika tidak ambil hari ini

    public function roomAvailability(Request $req){
        $date = date("m/d/y",time());
        if($req->date !== null){
            $date = date('m/d/y',strtotime($req->date));
        }

        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
        $json = json_decode($url, true);
        $details = $json["Details"];

        return view("Borrow.Room_Availability")->with("details",$details)->with("date",$json["Dates"]);
    }

    public function roomMonitor(Request $req){
        $date = date("m/d/y",time());
        if($req->date !== null){
            $date = date('m/d/y',strtotime($req->date));
        }
        $header = HeaderRoomTransaction::with("roomTransaction")->where("roomTransactionID","83204bba-dbe2-351b-a0c2-c5b50b0c9fc3")->first();
//        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
//        $json = json_decode($url, true);
//        $details = $json["Details"];
        dd($header);
        return view("Borrow.Room_Monitor")->with("date",$date);

    }
}
