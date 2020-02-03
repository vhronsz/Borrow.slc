<?php

namespace App\Http\Controllers;

use App\DetailItemTransaction;
use App\HeaderItemTransaction;
use App\Item;
use App\Mail\BorrowItemMail;
use App\Mail\BorrowRoomMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mail;
use App\Http\Requests;

class ItemTransactionController extends Controller
{
    public function add(Request $request){

        $item = Item::find($request->get('barang'));
        $item->itemStatus = 'Booked';
        $item->save();

        $phone = $request->get('phone');
        $name = $request->get('name');
        $email = $request->get('email');
        $itemName = $item->itemName;
        $id = $item->itemID;
        $borrowDate = $request->get('startDate');
        $returnDate = $request->get('endDate');

        //Validasi Phone
        if($phone[0] === '0'){
            $phone = substr($phone,1);
            $phone = "62" . $phone;
        }

        $data = new HeaderItemTransaction();
        $uuid = Uuid::uuid4();
        $data->itemTransactionID = $uuid;
        $data->adminID = Uuid::uuid4();
        $data->username = $request->get('name');
        $data->userEmail = $request->get('email');
        $data->userPhone = $request->get('phone');
        $data->transactionDate = Carbon::now()->toDateTimeString();
        $data->transactionStatus = $request->get('message');

        $detail = new DetailItemTransaction();
        $detail->itemTransactionID = $uuid;
        $detail->itemID = $request->get('barang');
        $detail->shiftStart = $request->get('startDate');
        $detail->shiftEnd = $request->get('endDate');
        $detail->bookType = 'booked';
        $detail->status = 'Registered';
        $data->save();
        $detail->save();
        $imageQR = QrCode::format('png')->size(500)->merge('storage/finalLogo.png',.3,true)->generate(''.$uuid);
        Storage::put('public/'.$uuid.'.png',$imageQR);

        $client = new \GuzzleHttp\Client();
        $filePath = "storage/$uuid.png";
        $fileContent = File::get($filePath);

        $tmp = explode('/', $filePath);
        $file_extension = end($tmp);

        //Glude
        Try {
            $response = $client->post(
                'borrow.douglasnugroho.com/upload.php', [
                'multipart' => [
                    [
                        'name'     => 'qr_code',
                        'contents' => $fileContent,
                        'filename' => $file_extension,
                    ],
                    [
                        'name'      => 'name',
                        'contents'  => $uuid
                    ]
                ],
            ]
            );
            $data = json_decode($response->getBody());
            $url = $data->url;

            //Send E-mail
            $data = array('name'=>$name,'url'=>$url,'itemName'=>$itemName,'id'=>$id,'borrowDate'=>$borrowDate,'returnDate'=>$returnDate);
            Mail::send('mail', $data, function($message)use($email,$filePath,$name) {
                $message->to($email, $name)->subject
                ('QRCode Items');
                $message->attach($filePath);
                $message->from("familyof18.2@gmail.com",'Vick Koesoemo Santoso');
            });

//            \Illuminate\Support\Facades\Mail::to($email)->send(new BorrowItemMail($name,$itemName,$id,$borrowDate,$returnDate,$imageQR,$url));
            //Send WhatsApp
            $text = "Dear%20Bapak/Ibu%20$name,%0A%0ABerikut%20adalah%20detail%20peminjaman%20alat%20yang%20diajukan:%0ANama%20alat:%20$itemName%0AKode%20alat:%20$id%0Atanggal%20peminjaman:%20$borrowDate%0Atanggal%20pengembalian:%20$returnDate%0A%0AAlat%20dapat%20diambil%20dan%20dikembalikan%20menggunakan%20qrcode%20terlampir.%20Qr%20code%20juga%20dapat%20di%20akses%20melalui:%20{$url}";
            return Redirect::to("https://api.whatsapp.com/send?phone=$phone&text=$text");

        } catch(Exception $e) {
            echo $e->getMessage();
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();

            echo $responseBody;
            exit;
        }
    }

    public function updateItemTransaction(Request $request){

        $id = $request->get('code');
        $data = DetailItemTransaction::find($id);
        $item = Item::find($data->itemID);

        if($data->status === 'Registered'){
            $data->status = 'Taken';
        }
        else if($data->status === 'Taken'){
            $item->itemStatus = 'Done';
            $item->save();
            $data->status = 'Done';
        }
        $data->save();
        return response(['status' => $data->status,'startDate'=>$data->shiftStart,'endDate'=>$data->shiftEnd,'itemName'=>$item->itemName],200);
    }

    public function getAllTransaction(){
        $data = HeaderItemTransaction::with('detailItemTransaction.item')->orderBy('created_at', 'ASC')->get();
//        return $data;
        return view('Item/Manage.itemTransaction',compact('data'));
    }

    public function filterTransactionData($id){
        $data = HeaderItemTransaction::with(["detailItemTransaction" => function($query)use($id){$query->where('status','=',''.$id);}])->orderBy('created_at', 'ASC')->get();
        return view('Item/Manage.itemTransaction',compact('data'));
    }

}
