<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('fazal.aman.dc@gmail.com', 'Fazal Aman')
                    ->subject('Order Confirmation')
                    ->view('emails.order_confirmation') // HTML email
                    ->text('emails.order_confirmation_plain') // Plaintext fallback
                    ->with([
                        'order' => $this->order
                    ]);
    }
}
