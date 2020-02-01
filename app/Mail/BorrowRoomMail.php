<?php

namespace App\Mail;

use App\HeaderRoomTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowRoomMail extends Mailable
{
    use Queueable, SerializesModels;


    protected $header;
    protected $qr;
    protected $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($header,$qr,$url)
    {
        //
        $this->header = $header;
        $this->qr = $qr;
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
                    ->view('Mail.RoomMail')
                    ->subject("Room Borrowing")
                    ->with("header",$this->header)
                    ->with("url",$this->url)
                    ->attachData($this->qr,'qr.png',[
                        "mime" => "image/png"
                    ]);
    }
}
