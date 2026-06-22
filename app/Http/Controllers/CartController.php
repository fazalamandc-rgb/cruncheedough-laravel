<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        Log::debug('Add to Cart method triggered');

        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'food_disserts' => 'required|array',
                'fsc' => 'required|array',
                'food_items' => 'required|array|min:1',
                'food_items.*' => 'exists:food_item,fitem_id', // Correct column name 'fitem_id'
            ]);

            // Fetch session data
            $customer_id = $request->session()->get('cid');
            $order_id = $request->session()->get('order_no');

            if (!$customer_id || !$order_id) {
                Log::error('Missing session data: cid or order_no not set.');
                return response()->json(['error' => 'Missing session data.'], 400);
            }

            // Loop through selected food items and insert them into the orders table
            foreach ($validated['food_items'] as $food_item_id) {
                $insertData = [
                    'order_id' => $order_id,
                    'food_id' => $validated['food_disserts'][0],
                    'fsub_categ_id' => $validated['fsc'][0],
                    'fitem_id' => $food_item_id, // Correct column name 'fitem_id'
                    'custormer_id' => $customer_id,
                    'order_date' => now(),
                    'payment' => 0,
                    'delivered' => 0,
                ];
                DB::table('orders')->insert($insertData);
            }
            // Get the updated cart count
          //  $cartCount = DB::table('orders')->where('custormer_id', $customer_id)->count();
          $cartCount = DB::table('orders')
          ->where('payment', 0)
          ->where('custormer_id', $customer_id)
          ->whereDate('order_date', '=', now()->toDateString())
          ->distinct('fitem_id')
          ->count('fitem_id');
      
            return response()->json(['cartCount' => $cartCount ]);

        } catch (\Exception $e) {
            Log::error('Error in addToCart:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }
}
