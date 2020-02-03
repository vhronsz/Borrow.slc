<?php

namespace App\Http\Controllers;

use App\HeaderItemTransaction;
use App\HeaderRoomTransaction;
use App\Mail\BorrowRoomMail;
use App\room;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionController extends Controller
{
    public function borrowForm(){
        $room = room::get();
        return view("Borrow.Form_Borrow")->with("room",$room);
    }

    public function getShiftStart($shift){
        $time = null;
        if($shift === 1){
            $time = "07:20";
        }else if($shift === 2){
            $time = "09:20";
        }else if($shift === 3){
            $time = "11:20";
        }else if($shift === 4){
            $time = "13:20";
        }else if($shift === 5){
            $time = "15:20";
        }else if($shift === 6){
            $time = "17:20";
        }else if($shift === 7) {
            $time = "19:20";
        }
        return $time;
    }

    public function getShiftEnd($shift){
        $time = null;
        if($shift === 1){
            $time = "09:00";
        }else if($shift === 2){
            $time = "11:00";
        }else if($shift === 3){
            $time = "13:00";
        }else if($shift === 4){
            $time = "15:00";
        }else if($shift === 5){
            $time = "17:00";
        }else if($shift === 6){
            $time = "19:00";
        }else if($shift === 7) {
            $time = "21:00";
        }
        return $time;
    }

    public function getTransactionEnd($index,$data){
        $totalShift = 0;
        //Index Start from 0 - 6
        while($index+1 <= 6){
            //Check if the shift after is null or not
            if($data[$index+1]){
                if($data[$index+1][0]["Description"] === $data[$index][0]["Description"]){
                    $totalShift++;
                }else{
                    break;
                }
            }else{
                break;
            }
            $index++;
        }
        return $totalShift;
    }

    public  function addRoom(Request $req){

        $valid = Validator::make($req->all(),[
            "name" => "required|min:2",
            "email" => "required|email",
            "phone" => "required|numeric|digits_between:12,14",
            "room" => "required",
            "shiftStart" => "required",
            "shiftEnd" => "required",
            "date" => "required",
            "borrowReason" =>"required",
            "division" => "required"
        ]);

        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }else {
            $checkHeader =  HeaderRoomTransaction::where("transactionDate", $req->date)->get();
            $shiftStart = (int) $req->shiftStart ;
            $shiftEnd = (int) $req->shiftEnd;
            //Check if Start shift is bigger than end shift
            if ($shiftStart >$shiftEnd) {
                return redirect()->back()->withErrors("Shift Start Cannot Exceed Shift End");
            }
            //Check if there is a transaction on selected shift
            foreach ($checkHeader as $header){
                if ($this->checkTransactionValid($header,$req)){
                    return redirect()->back()->withErrors("There is another transaction in selected shift");
                }
            }
            $header = new HeaderRoomTransaction();
            $header->roomTransactionID = Uuid::uuid();
            $header->adminID = Uuid::uuid();

            $header->transactionStatus = "Registered";
            $header->campus = "ANGGREK";

            $header->borrowerName = $req->name;
            $header->borrowerEmail = $req->email;
            $header->borrowerPhone = $req->phone;
            $header->roomID = $req->room;

            $header->shiftStart = $req->shiftStart;
            $header->shiftEnd = $req->shiftEnd;
            $header->timeStart = $this->getShiftStart((int)$req->shiftStart);
            $header->timeEnd = $this->getShiftEnd((int)$req->shiftEnd);
            $header->transactionDate = $req->date;
            $header->borrowerDivision = $req->division;
            $header->borrowReason = $req->borrowReason;

            if ($req->internetRequest === "yes") {
                $validInet = Validator::make($req->all(), [
                    "internetReason" => "required"
                ]);
                if ($validInet->fails()) {
                    return redirect()->back()->withErrors($validInet->errors());
                }
                $header->internetRequest = true;
                $header->internetReason = $req->internetReason;
            }else{
                $header->internetRequest = false;
            }

            $header->save();
            $qr = QrCode::format("png")->size(500)->generate($header->roomTransactionID);

            Storage::put('public/'.$header->roomTransactionID.'.png',$qr);
            $client = new \GuzzleHttp\Client();
            $filePath = "storage/$header->roomTransactionID.png";
            $fileContent = File::get($filePath);

            $tmp = explode('/', $filePath);
            $file_extension = end($tmp);

            $client = new Client();

            Try {
                $response = $client->post(
                    'borrow.douglasnugroho.com/upload.php', [
                        'multipart' => [
                            [
                                'name'     => 'qr_code',
                                'contents' => $qr,
                                'filename' => $file_extension,
                            ],
                            [
                                'name'      => 'name',
                                'contents'  => $header->roomTransactionID
                            ]
                        ],
                    ]
                );
            } catch(Exception $e) {
                echo $e->getMessage();
                $response = $e->getResponse();
                $responseBody = $response->getBody()->getContents();
                echo $responseBody;
                exit;
            }

            $data = json_decode($response->getBody());
            $url = $data->url;
            $this->sendRoomMail($header,$qr,$url);
            $message = $this->sendWA($header,$url);
            return Redirect::to("https://api.whatsapp.com/send?phone=$header->borrowerPhone&text=".$message);
//            return redirect('/view/room/Home')->with("message","Transaction Added");
        }
    }

    public function checkTransactionValid($header,$req){
        $shiftStart = (int) $req->shiftStart;
        $shiftEnd = (int) $req->shiftEnd;

        //Cek masalah transaksi jika ruangannya sama
        if($header->roomID === $req->room) {
            //Cek if shift yang dipilih bentrok dengan transaksi yang sudah ada
            if( $header->shiftStart == $shiftStart || $header->shiftEnd == $shiftStart ||
                $header->shiftStart == $shiftEnd || $header->shiftEnd == $shiftEnd){
                return true;
            }
            //Cek apakah shift yang dipilih melewati transaksi yang ada
            else if($shiftStart <= $header->shiftStart && $shiftEnd >= $header->shiftEnd){
                return true;
                //Cek apakah shift yang dipilih berada pada jam dilaksanakan transaksi
            }else if($shiftStart >= $header->shiftStart && $shiftEnd <= $header->shiftEnd){
                return true;
            }
        }
        return false;
    }

    public function sendWA($header,$url){
        $message = "Dear+".$header->borrowerName."%2C%0D%0A%0D%0ABerikut+adalah+detail+peminjaman+ruang+yang+diajukan%3A%0D%0Atanggal%3A+".\date('d/m/Y',strtotime($header->transactionDate))."%0D%0Aruang%3A+".$header->roomID."%0D%0Ashift%3A+".$header->shiftStart."+-+".$header->shiftEnd."%0D%0Awaktu%3A+".$header->timeStart."+-+".$header->timeEnd."%0D%0A%0D%0AKunci+ruangan+dapat+diambil+dan+dikembalikan+menggunakan+qrcode+terlampir.+Qr+code+juga+dapat+di+akses+melalui%3A+".$url;
        if($header->shiftStart === $header->shiftEnd){
            $message = "Dear+".$header->borrowerName."%2C%0D%0A%0D%0ABerikut+adalah+detail+peminjaman+ruang+yang+diajukan%3A%0D%0Atanggal%3A+".\date('d/m/Y',strtotime($header->transactionDate))."%0D%0Aruang%3A+".$header->roomID."%0D%0Ashift%3A+".$header->shiftStart."%0D%0Awaktu%3A+".$header->timeStart."+-+".$header->timeEnd."%0D%0A%0D%0AKunci+ruangan+dapat+diambil+dan+dikembalikan+menggunakan+qrcode+terlampir.+Qr+code+juga+dapat+di+akses+melalui%3A+".$url;
        }
        return $message;
    }

    public function sendRoomMail($header,$qr,$url){
        //Send E-mail\
        Mail::to($header->borrowerEmail)->send(new BorrowRoomMail($header,$qr,$url));
    }

    //cara update dia liat brp shift kalo satu 30 menit pertama kalo dua liat di shift terakhirnya
    public function updateRoom(Request $req){
        $header = HeaderRoomTransaction::where("roomTransactionID",$req->data)->first();
        if($header){
            //Validasi apkakah harinya sudah sama dan cek apakah waktu sekarang sudah 20 menit sbeelum shift mulai
            if($this->getSameDay($header->transactionDate)){
                if($header->transactionStatus === "Done"){
                    return response()->json([
                        "message" => "Thank you your transaction is done",
                        "transaction" => $header,
                        "color" => "green"
                    ]);
                }
                else if($header->transactionStatus === "Registered" && $this->getTimeStart($header->shiftStart)){
                    $header->transactionStatus = "Taken";
                    $header->save();

                    return response()->json([
                        "message" => "Your Scheduled Transaction :",
                        "transaction" => $header,
                        "color" => "green"
                    ]);

                }
                else if (
                    //Check if the time already pass the transaction time and check if 30 minutes already passed
                    $header->transactionStatus === "Taken" &&
                    $this->getHour($header->shiftStart) &&
                    ($this->getTimeDone($header->shiftStart) ||
                        $this->getTimeDone($header->shiftEnd))
                )
                {
                    $header->transactionStatus = "Done";
                    $header->save();
                    return response()->json([
                        "message" => "Thank you your transaction is done",
                        "transaction" => $header,
                        "color" => "green"
                    ]);
                }

            }else{
                return response()->json([
                    "message" => "Sorry your transaction has not happen",
                    "transaction" => $header,
                    "color" => "green"
                ]);
            }
        }
        else{
            return response()->json([
                "message"=>"Transaction Not Found",
                "color"=>"red",
                "id"=>$req->data
            ]);
        }

    }

    public function getSameDay($day){
        $dateNow = getdate(strtotime(Carbon::now()))["yday"];
        $dateTransaction = getdate(strtotime($day))["yday"];
        if($dateTransaction <= $dateNow){
            return true;
        }
        return false;
    }

    public function getHour($shift)
    {
        $shift = (int) $shift;
        $shiftTime = \date("H", strtotime($this->getShiftStart($shift)));
        $now = \date("H", strtotime(Carbon::now()));
        if($now >= $shiftTime){
            return true;
        }else{
            return false;
        }
    }

    public function getTimeStart($shift){
        $shift = (int)$shift;
        $shiftHour = \date("H", strtotime($this->getShiftStart($shift)));
        $nowHour = \date("H", strtotime(Carbon::now()));
        $shiftMinute = \date("i", strtotime($this->getShiftStart($shift)));
        $nowMinute = \date("i", strtotime(Carbon::now()));

        $shiftTime = ($shiftHour * 60) + $shiftMinute;
        $now = ($nowHour * 60) + $nowMinute;


        if($shiftTime - $now > -1){
            if($shiftTime - $now <= 60){
                return true;
            }
        }else{
            return true;
        }
    }

    public function getTimeDone($shift){
        $shift = (int)$shift;
        $shiftHour = \date("H", strtotime($this->getShiftEnd($shift)));
        $nowHour = \date("H", strtotime(Carbon::now()));
        $shiftMinute = \date("i", strtotime($this->getShiftEnd($shift)));
        $nowMinute = \date("i", strtotime(Carbon::now()));

        $shiftTime = ($shiftHour * 60) + $shiftMinute;
        $now = ($nowHour * 60) + $nowMinute;

        if($now-$shiftTime>=29){
            return true;
        }else{
            return false;
        }
    }


    public function getDataFromMessier(){
        $date = date("m/d/y",time());

        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
        $json = json_decode($url, true);

        $data = $json["Details"];
        $date = $json["Dates"][0];
        foreach ($data as $tdata){
            $index = 0;
            while($index < 7) {
                if ($tdata["StatusDetails"][$index]) {
                    $header = new HeaderRoomTransaction();
                    $header->roomTransactionID = Uuid::uuid();
                    $header->adminID = Uuid::uuid();
                    $header->transactionDate = $date;
                    $header->transactionStatus = "Registered";
                    $header->campus = $tdata["Campus"];
                    $header->roomID = $tdata["RoomName"];

                    $transaction = $tdata["StatusDetails"][$index][0];
                    $header->borrowerName = $transaction["Name"];
                    $header->borrowerEmail = $transaction["Email"];
                    $header->borrowerPhone = null;
                    $header->borrowerDivision = $transaction["Division"];
                    $header->borrowerName = $transaction["Name"];
                    $header->shiftStart = $index + 1;
                    $header->borrowReason = $transaction["Description"];

                    if ($transaction["NeedInternet"] === true) {
                        $header->internetRequest = true;
                    } else {
                        $header->internetRequest = false;
                    }

                    if ($transaction["Assistant"]) {
                        $header->assistant = $transaction["Assistant"];
                    }

                    //Get Shift end from all transaction
                    //Check if current index is not the last index and the next index is not null
                    if($index<6 && $tdata["StatusDetails"][$index][0]){
                        $totalShift = $this->getTransactionEnd($index,$tdata["StatusDetails"]);
                        $header->shiftEnd = $header->shiftStart + $totalShift;
                        $index = $header->shiftEnd;
                    }
                    else{
                        $header->shiftEnd = $header->shiftStart;
                        $index++;
                    }
                    $header->timeStart = $this->getShiftStart($header->shiftStart);
                    $header->timeEnd = $this->getShiftEnd($header->shiftEnd);
                    $header->save();
                }
                else {
                    $index++;
                    continue;
                }
            }

        }
        return Redirect::to('/view/room/Home');
    }

    public function roomMonitor(Request $req){
        $floor = 6;
        $timeNow = (int)\date("H",strtotime(Carbon::now()));
        $header = null;
        $data = [];

        if (isset($req->floor)){
            $floor = (int)$req->floor;
        }

        if($timeNow >= 21){
            return view("Borrow.Room_Monitor");
        }

        if($floor === 6){
            $room = room::where("roomFloor",6)->get();
            $header = HeaderRoomTransaction::where("roomID","like","6"."%")
                        ->where("transactionDate",\date("Y-m-d H:i:s",strtotime("2020-02-01 0:0:0")))
                        ->get();
        }else if($floor === 7){
            $room = room::where("roomFloor",7)->get();
            $header = HeaderRoomTransaction::where("roomID","like","7"."%")
                        ->where("transactionDate",\date("Y-m-d H:i:s",strtotime("2020-02-01 0:0:0")))
                        ->get();
        }

        foreach ($room as $r){
            $color = "";
            foreach ($header as $h){
                if($r->roomID === $h->roomID){
                    if($h->shiftEnd < $this->getClosestShift() && $this->getMinuteDifference($h->shiftEnd) && $h->transactionStatus === "Taken"){
                        $color = "#e72537";
                        break;
                    }
                    if($this->getClosestShift() >= $h->shiftStart && $this->getClosestShift() <= $h->shiftEnd){
                        $color = "#0f61ff";
                        break;
                    }
                }
            }
            array_push($data,["room"=>$r,"color"=>$color]);
        }
        return view("Borrow.Room_Monitor")->with("data",$data);
    }
    
    public function getClosestShift(){
        $nowHour = \date("H", strtotime(Carbon::now()));
        $nowMinute = \date("i", strtotime(Carbon::now()));
        $now = ($nowHour * 60) + $nowMinute;
        $shift = 1;
        for($i=1;$i<7;$i++){
            $shiftStart = $this->getShiftStart($i);
            $shiftHourStart = getdate(strtotime($shiftStart))["hours"];
            $shiftMinuteStart = getdate(strtotime($shiftStart))["minutes"];
            $timeStart = ($shiftHourStart*60)+$shiftMinuteStart;

            $shiftEnd = $this->getShiftEnd($i);
            $shiftHourEnd = getdate(strtotime($shiftEnd))["hours"];
            $shiftMinuteEnd = getdate(strtotime($shiftEnd))["minutes"];
            $timeEnd = ($shiftHourEnd*60)+$shiftMinuteEnd;

            if($now >= $timeStart && $now <= $timeEnd){
                return $i;
            }

        }
        return $shift;
    }

    public function getMinuteDifference($shift){
        $nowHour = \date("H", strtotime(Carbon::now()));
        $nowMinute = \date("i", strtotime(Carbon::now()));
        $now = ($nowHour * 60) + $nowMinute;

        $shiftEnd = $this->getShiftEnd($shift);
        $shiftHourEnd = getdate(strtotime($shiftEnd))["hours"];
        $shiftMinuteEnd = getdate(strtotime($shiftEnd))["minutes"];
        $timeEnd = ($shiftHourEnd*60)+$shiftMinuteEnd;

        if($now - $timeEnd >20){
            return true;
        }
        return false;
    }

    
    public function fetchMonitorRoom(Request $req){

        if($req->data === 6 || $req->data === null){
            $header = HeaderRoomTransaction::where("roomID","like","6"."%")->get();
        }else{
            $header = HeaderRoomTransaction::where("roomID","like","7"."%")->get();
        }

        return response()->json([
            "message" => "Success",
            "floor" => $header
        ]);
    }

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

    public function borrowHistory(Request $req){
        $transaction = HeaderRoomTransaction::paginate(10);
        if(isset($req->date) || $req->date !== null){
            $transaction = HeaderRoomTransaction::where('transactionDate',$req->date)->paginate(10);
        }
        return view("Borrow.RoomHistory")->with("item",$transaction);
    }

    public function deleteRoomTransaction($id){
        $transaction = HeaderRoomTransaction::where("roomTransactionID",$id)->first();
        $transaction->delete();
        return \redirect('/view/room/History_Room');
    }

    /////////////////////////////////////////
    public function dump(){

    }

}
