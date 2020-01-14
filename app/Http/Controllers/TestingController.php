<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    //
    public function a(Request $req){
        redirect($req->data);
        return response()->json($req->data);
    }
}
