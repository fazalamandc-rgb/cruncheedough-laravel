<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; // Import Log
class OrderConfirmationMail1 extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
{
    return $this->subject('Order Confirmation')
                ->view('emails.order_confirmation1') // HTML Email
                ->text('emails.order_confirmation1_plain') // Plain Text Email
                ->with('details', $this->details);
}
}
