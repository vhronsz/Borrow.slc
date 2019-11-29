<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    //

    public function doLogin(Request $request)
    {

        return response()->json([
            "message" => "Route Working"
        ]);
    }
}
