<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["prefix" => "view"],function(){

    Route::get('Login',function(){
        return view('login');
    });

    Route::get('Borrow_Room_Form',function(){
        return view('Borrow.Form_Borrow');
    });

    Route::get('/Home',function(){
        return view('Borrow.ScanRoomQR');
    });

});

Route::group(["prefix" => "room"],function(){
    Route::get('Room_Availability',"ViewController@roomAvailability");
    Route::post('Room_Availability',"ViewController@roomAvailability");

    Route::get('Room_Monitor',"ViewController@roomMonitor");
    Route::post('Room_Monitor',"ViewController@roomMonitor");
});

Route::group(["prefix" => "transaction"],function (){
    Route::post("/Add_Room","TransactionController@addRoom");
    Route::get('/Update_Room','TransactionController@updateRoom');
});

Route::group(["prefix"=>"auth"],function(){
    Route::post("Login","UserController@doLogin");
});


////////////////
////Not Used////
////////////////
Route::get('/', function () {
    return view('welcome');
});

Route::post('/master', function () {
    return view('Master.master');
});

Route::get('/master', function () {
    return view('Master.master');
});

Route::group(['prefix'=>'testing'],function (){
    Route::get("qrscan2",function(){
        return view("testing/QrScanner2",["Testing"=>"Nama"]);
    });
    Route::get("a","QRController@a");
    Route::get("qr",function(){
        return view("testing.qrtesting");
    });
});
