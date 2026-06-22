<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail1; // Updated to use the new Mailable


class CounterController extends Controller
{
    public function showcounter()
    {
        $sd = date('Y-m-d');
        
        // Fetch distinct orders based on the date
        $orders = DB::table('orders')
            ->select('order_id', 'custormer_id')
            ->where('order_date', '=', $sd)
            ->distinct()
            ->get();
    
        $output = [];
        
        foreach ($orders as $order) {
            // Fetch customer information
            $customer = DB::table('customers')
                ->where('customer_id', $order->custormer_id)
                ->first();
    
            $orderDetails = DB::table('orders')
                ->join('food_item', 'orders.fitem_id', '=', 'food_item.fitem_id')
                ->join('food_sub_categ', 'orders.fsub_categ_id', '=', 'food_sub_categ.fsub_categ_id')
                ->select('food_item.item_description', 'food_item.unit_price', 'orders.payment', 'orders.delivered', 'food_sub_categ.fs_descriptions')
                ->where('orders.order_date', '=', $sd)
                ->where('orders.custormer_id', '=', $order->custormer_id)
                ->where('orders.order_id', '=', $order->order_id)
                ->get();
    
            $totalAmount = 0;
            foreach ($orderDetails as $detail) {
                // Remove the pound symbol and add the price to the total
                $unitPrice = str_replace('£', '', $detail->unit_price); // Remove pound symbol
                $totalAmount += (float) $unitPrice; // Add the price as a float to the total
            }
    
            // Add the order data to the output, including the delivered status and totalAmount
            $output[] = [
                'order_id' => $order->order_id,
                'customer_name' => $customer->customer_name,
                'customer_email' => $customer->customer_id, // Assuming `customer_id` is an email/phone
                'total_amount' => $totalAmount,
                'order_details' => $orderDetails,
                'delivered' => $orderDetails->first()->delivered ?? 0, // Default to 0 if not available
                'payment' => $orderDetails->first()->payment ?? 0, // Default to 0 if not available
            ];
        }
    
        // Return the view with the output variable
      //  return view('counter.index', compact('output', 'sd'));
        return view('counter.index', ['output' => $output ?? [], 'sd' => $sd]);
    }


    public function sendEmail(Request $request)
    {
        $orderId = $request->input('order_id');
        $customerEmail = $request->input('customer_email');
        $totalAmount = $request->input('total_amount'); // Ensure correct key
    
        if (!$customerEmail) {
            return back()->with('error', 'Customer email not found.');
        }
    
        // Format total amount with currency symbol
        $formattedTotal = '£' . number_format((float) $totalAmount, 2);
    
        // Email content
        $details = [
            'title' => 'Order Confirmation',
            'body' => "Your payment for Order ID: $orderId amount: $formattedTotal has been received successfully. Thank you!",
            'total_amount' => $formattedTotal, // Pass formatted amount separately
        ];
    
        Log::info('Email details:', $details);
        Mail::to($customerEmail)->send(new OrderConfirmationMail1($details));
        return back()->with('success', 'Email sent successfully.');
    }



    
    public function updateOrder(Request $request)
    {
        // Manual validation using Validator facade
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'payment' => 'required|in:0,1', // Ensure payment is either 0 or 1
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back with error messages if validation fails
            return redirect()->route('counter')
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Proceed with updating the order if validation passes
        DB::table('orders')
            ->where('order_id', $request->order_id)
            ->whereDate('order_date', '=', now()->toDateString()) // Filter by current date
            ->update([
            'payment' => $request->payment, // Update only the payment field
            ]);
    
        // Log the update action
        Log::info("Payment updated for Order ID: " . $request->order_id);
    
        // Redirect back with success message
        return redirect()->route('counter')->with('success', 'Payment updated successfully!');
    }


    
    
}
