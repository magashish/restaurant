<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlcaed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderData = [])
    {
        $this->orderData = $orderData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@restaurant.com', "Restaurant App")
            ->subject('Order has been placed successfully ' . $this->orderData->oid)
            ->view('mail.order-placed')
            ->with(['orderData' => $this->orderData]);
    }
}
