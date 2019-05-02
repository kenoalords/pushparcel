<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Parcel;

class ParcelRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $parcel;
    public function __construct(Parcel $parcel)
    {
        $this->parcel = $parcel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your Parcel Pickup Request")
                    ->to([ $this->parcel->sender_email ])
                    ->markdown('mails.parcel.request');
    }
}
