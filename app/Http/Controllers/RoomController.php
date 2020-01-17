<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    public function changeDate(Request $request){

        $date = date(Carbon::parse($request->date));
        $date = date("m/d/y",strtotime($date));
        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
        $json = json_decode($url, true);
        $details = $json["Details"];
        Session::put("Date","");
        return view("Borrow.Room_Availability")->with("details",$details);
    }
}
