<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        // Step 1: Retrieve the customer ID from the session
        $cust_id = Session::get('cid');
        
        // Step 2: Handle case if the customer is not logged in
        if (!$cust_id) {
            return response()->json(['error' => 'Customer not logged in or session expired'], 400);
        }

        // Step 3: Retrieve data from the request
        $food_disserts = $request->input('food_disserts', []);  // Food category IDs
        $fsc = $request->input('fsc', []);  // Sub-category IDs
        $items = $request->input('item', []);  // Selected food items

        // Step 4: Validate the incoming data
        if (empty($food_disserts) || empty($fsc) || empty($items)) {
            return response()->json(['error' => 'Missing required data'], 400);
        }

        // Step 5: Generate or retrieve the current order ID
        // Look for an existing order for the customer today
        $order = Order::where('custormer_id', $cust_id)
            ->whereDate('order_date', today())  // Ensures we are working with today's orders
            ->where('payment', 0)  // Only consider unpaid orders
            ->first();
        
        // If no order exists, create a new one
        if (!$order) {
            // Generate a new order ID (assuming it's not auto-incrementing)
            $order_id = Order::max('order_id') + 1;
            Session::put('order_no', $order_id);

            // Create a new order entry
            $order = new Order();
            $order->order_id = $order_id;
            $order->custormer_id = $cust_id;
            $order->order_date = now();
            $order->payment = 0;
            $order->delivered = 0;
            $order->save();
        } else {
            $order_id = $order->order_id;
            Session::put('order_no', $order_id);
        }

        // Step 6: Insert the food items into the orders table
        foreach ($items as $item_id) {
            // Check if the item already exists in the order for the current order
            $exists = Order::where('order_id', $order_id)
                ->where('custormer_id', $cust_id)
                ->where('food_id', $food_disserts[0]) // Assuming one sub-category for simplicity
                ->where('fsub_categ_id', $fsc[0]) // Assuming one sub-category for simplicity
                ->where('fitem_id', $item_id)
                ->exists();

            if (!$exists) {
                // Insert the item only if it doesn't already exist
                $newOrder = new Order();
                $newOrder->order_id = $order_id;
                $newOrder->food_id = $food_disserts[0]; // Assuming one food category for simplicity
                $newOrder->fsub_categ_id = $fsc[0]; // Assuming one sub-category for simplicity
                $newOrder->fitem_id = $item_id;
                $newOrder->custormer_id = $cust_id;
                $newOrder->order_date = now();
                $newOrder->payment = 0;
                $newOrder->delivered = 0;
                $newOrder->save();
            }
        }

        // Step 7: Return the updated cart item count
        $cartCount = Order::where('custormer_id', $cust_id)
            ->whereDate('order_date', today())
            ->where('payment', 0)
            ->count();

        // Store the updated cart count in the session
        Session::put('cart_count', $cartCount);

        // Step 8: Return a success response
        return response()->json(['cartCount' => $cartCount], 200);
    }
}
