<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ItemController extends Controller
{
    public function add(Request $request){
        $data = new Item();
        $data->itemID = $request->get('itemId');
        $data->itemName = $request->get('itemName');
        $data->itemDesc = $request->get('itemDescription');
        $data->itemStatus = 'Done';
        $data->save();
        return redirect('/view/item/addItem');
    }

    public function find($id){
        $item = Item::find($id);
        return $item;
    }

    public function viewUpdate(){
        $data = Item::where('itemStatus','=','Done')->get();
        return view('Item/Manage.updateBarang',compact('data'));
    }

    public function update(Request $request){

        $data = Item::find($request->get('barang'));
        $data->itemName = $request->get('itemName');
        $data->itemID = $request->get('itemId');
        $data->itemDesc = $request->get('itemDescription');
        $data->save();
        return redirect('/view/item/updateItem');

    }

    public function viewDelete(){
        $data = Item::all();
        return view('Item/Manage.deleteBarang',compact('data'));
    }

    public function destroy(Request $request){
        $data = Item::find($request->get('barang'));
        $data->delete();
        return redirect('/view/item/deleteItem');
    }

    public function viewFormPeminjaman(){
        $data = Item::all();
        return view('Item/Manage.formPeminjamanBarang',compact('data'));
    }
}