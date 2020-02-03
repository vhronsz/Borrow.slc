<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowItemMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name,$itemName,$id,$borrowDate,$returnDate,$imageQR,$url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$itemName,$id,$borrowDate,$returnDate,$imageQR,$url)
    {
        //
        $this->imageQR= $imageQR;
        $this->name = $name;
        $this->itemName=$itemName;
        $this->id=$id;
        $this->borrowDate =$borrowDate;
        $this->returnDate=$returnDate;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("ryansanjaya290799@gmail.com")
            ->view('mail')
            ->subject("Item Borrowing")
            ->with("name",$this->name)
            ->with("itemName",$this->itemName)
            ->with("id",$this->id)
            ->with("borrowDate",$this->borrowDate)
            ->with("returnDate",$this->returnDate)
            ->with("url",$this->url)
            ->attachData($this->imageQR,'qr.png',[
                'mime'=> "image/png"
            ]);

    }
}
