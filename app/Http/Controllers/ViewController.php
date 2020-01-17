<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller
{
    //View and Room
//    Kalo ada tanggal cari transaksi sesuai tanggal , jika tidak ambil hari ini

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


}
