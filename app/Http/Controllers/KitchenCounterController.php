<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class KitchenCounterController extends Controller
{
       public function showKitchenCounter()
    {
        $sd = date('Y-m-d');
        
        // Fetch distinct orders based on the date
        $orders = DB::table('orders')
            ->select('order_id', 'custormer_id')
            ->where('order_date', '=', $sd)
            ->where('orders.payment', '=', 1)
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
        return view('kitchen.index', compact('output', 'sd'));
    }
    
    public function updateOrderStatus(Request $request)
    {
        // Manual validation using Validator facade
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'delivered' => 'required|in:0,1', // Ensure delivered is either 0 or 1
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->route('kitchen')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Proceed with updating the order if validation passes
        DB::table('orders')
            ->where('order_id', $request->order_id)
            ->whereDate('order_date', '=', now()->toDateString()) // Filter by current date
            ->update([
                'delivered' => $request->delivered, // Update only the delivered field
            ]);

        // Log the update action
        Log::info("Delivery status updated for Order ID: " . $request->order_id);

        // Redirect back with success message
        return redirect()->route('kitchen')->with('success', 'Order delivered status updated successfully!');
    }
}
