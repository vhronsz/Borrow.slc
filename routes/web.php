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
    Route::group(["prefix" => "room"],function(){
        Route::get('Borrow_Room_Form',function(){
            return view('Borrow.Form_Borrow');
        });
        Route::get('/Home',function(){
            return view('Borrow.ScanRoomQR');
        });
    });
    Route::group(["prefix" => "item"],function(){
        Route::get('/ScanItem',function(){
            return view('Item.ItemQR');
        });
        Route::get('/UpdateItem',function(){
            return view('Item.formPeminjamanBarang');
        });
    });
});

Route::group(["prefix" => "room"],function(){
    Route::get('Room_Availability',"ViewController@roomAvailability");
    Route::post('Room_Availability',"ViewController@roomAvailability");

    Route::get('Room_Monitor',"ViewController@roomMonitor");
    Route::post('Room_Monitor',"ViewController@roomMonitor");
});

Route::group(["prefix" => "transaction"],function (){
    Route::post("/Add_Room_Transaction","TransactionController@addRoom");
    Route::get('/Update_Room_Transaction','TransactionController@updateRoom');

    Route::post("/Add_Item_Transaction","TransactionController@addItemTransaction");
    Route::get('/Update_Item_Transaction','TransactionController@updateItemTransaction');
});

Route::group(["prefix"=>"migration"],function(){
    Route::get("Test_Migration","TransactionController@getDataFromMessier");
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

Route::group(["prefix"=>"auth"],function(){
    Route::post("Login","UserController@doLogin");
});
