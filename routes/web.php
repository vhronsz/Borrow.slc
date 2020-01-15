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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/master', function () {
    return view('Master.master');
});

Route::get('/master', function () {
    return view('Master.master');
});

Route::group(["prefix" => "view"],function(){
    Route::get('login',function(){
        return view('login');
    });
    Route::get('Room_Monitor',function(){
        return view('monitorRoom');
    });
    Route::get('Borrow_Room_Form',function(){
        return view('Borrow.Form_Borrow');
    });
});

Route::post("/Add_Transaction","TransactionController@Add");

Route::group(["prefix"=>"auth"],function(){
    Route::post("login","UserController@doLogin");
});


Route::group(['prefix'=>'testing'],function (){

    Route::get('qr', function () {
        return view('testing\qrtesting')->with("key","83204bba-dbe2-351b-a0c2-c5b50b0c9fc3");
    });

    Route::get("qrscan",function(){
        return view("testing/QrScanner",["Testing"=>"Nama"]);
    });

    Route::get("qrscan2",function(){
        return view("testing/QrScanner2",["Testing"=>"Nama"]);
    });

    Route::get("a","TestingController@a");
});


