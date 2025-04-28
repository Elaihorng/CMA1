<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // This is where you should declare the public property

    // Constructor to initialize the order
    public function __construct(Order $order)
    {
        $this->order = $order; // Assign the order to the property
    }

    public function build()
    {
        return $this->view('emails.order_confirmed') // The view to render the email
                    ->with([
                        'order' => $this->order, // Pass the order to the view
                    ]);
    }
}

