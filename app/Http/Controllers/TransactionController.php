<?php

namespace App\Http\Controllers;

use App\DetailRoomTransaction;
use App\HeaderItemTransaction;
use App\HeaderRoomTransaction;
use App\Mail\BorrowRoomMail;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use GuzzleHttp\Client;
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
            $time = "09:20";
        }else if($shift === 2){
            $time = "11:20";
        }else if($shift === 3){
            $time = "13:20";
        }else if($shift === 4){
            $time = "15:20";
        }else if($shift === 5){
            $time = "17:20";
        }else if($shift === 6){
            $time = "19:20";
        }else if($shift === 7) {
            $time = "21:20";
        }
        return $time;
    }

    public function getEndShift($index,$data){
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

    public function getSameDay($day){
        if(Carbon::now()->diffInDays($day) === 0){
            return true;
        }
        return false;
    }

    public function getTime($shift)
    {
        $shiftTime = \date("h", strtotime($this->getShiftStart($shift)));
        $now = \date("h", strtotime(Carbon::now()));
        if($now >= $shiftTime){
            return true;
        }else{
            return false;
        }
    }

    public function getTimeDone($shift){
        if(Carbon::now()->diffInSeconds($this->getShiftEnd($shift)) >= 1795){
            return true;
        }

        return false;
    }

    public  function addRoom(Request $req){

        $valid = Validator::make($req->all(),[
            "name" => "required|min:2",
            "email" => "required|email",
            "phone" => "required|numeric|digits_between:10,12",
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
            return redirect('/view/room/Home')->with("message","Transaction Added");
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
        return Redirect::away("https://api.whatsapp.com/send?phone=$header->phone&text=".$message);
    }

    public function sendRoomMail($header,$qr,$url){
        //Send E-mail\
        Mail::to("ryansanjaya290799@gmail.com")->send(new BorrowRoomMail($header,$qr,$url));
    }

    //cara update dia liat brp shift kalo satu 30 menit pertama kalo dua liat di shift terakhirnya
    public function updateRoom(Request $req){
        $header = HeaderRoomTransaction::where("roomTransactionID",$req->data)->first();
        if($header){
            //Check if transaction is on the same day
            if($header->transactionStatus === "Registered" && $this->getSameDay($header->transactionDate)){
                $header->transactionStatus = "Taken";
                $header->save();
            }
            //Check if the time already pass the transaction time and check if 30 minutes already passed
            else if($header->transactionStatus === "Taken" && $this->getTime($header->shiftStart) && $this->getTimeDone($header->shiftStart) || $this->getTimeDone($header->shiftEnd)){
                $header->transactionStatus = "Done";
                $header->save();
            }
            //Add Shift and Room
            return response()->json([
                "message"=>"Transaction Updated",
                "status"=>$header->transactionStatus,
                "color"=>"green",
                "time"=>Carbon::now()->diffInSeconds($header->updated_at)
            ]);
        }else{
            return response()->json([
                "message"=>"Transaction Not Found",
                "color"=>"red","id"=>$req->data
            ]);
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
                        $totalShift = $this->getEndShift($index,$tdata["StatusDetails"]);
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
        return response()->json([
            "Message" => "Fetching Data Success",
            "status" => true
        ]);

    }

    public function dump(){
        $qr = QrCode::format("png")->size(300)->generate("asd");
        return view("testing.qrtesting")->with("qr",$qr);
    }

}
