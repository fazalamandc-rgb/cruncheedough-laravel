<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class OrderControllerEmail extends Controller
{
    public function sendOrderEmail()
    {
        $order = [
            'id' => 1234,
            'customer_name' => 'Dr. Fazal Aman',
            'total' => 250
        ];

        // Debug: Log the rendered email content
        Log::info(view('emails.order_confirmation', ['order' => $order])->render());

        Mail::to('fazalaman@uop.edu.pk')->send(new OrderConfirmationMail($order));

        return "Email sent successfully!";
    }
}
