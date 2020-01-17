<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller
{
    public function roomAvailability(Request $req)
    {
        if (!Session::get("Date")) {
            Session::put("Date",date("m/d/y",time()));
        }
        $date = Session::get("Date");

        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
        $json = json_decode($url, true);
        $details = $json["Details"];

        return view("Borrow.Room_Availability")->with("details",$details)->with("date",$json["Dates"]);
    }


}
