<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CartView extends Controller
{
    public function index()
    {
        $cid = session('cid'); 
    
        // Fetch cart items
        $query = "
            SELECT 
                orders.custormer_id AS cid,
                orders.fitem_id AS itm,
                orders.order_date AS dt,
                food_item.item_description AS ds,
                food_item.unit_price AS up,
                fsc.fs_descriptions AS fscds
            FROM 
                orders
            JOIN food_item ON orders.fitem_id = food_item.fitem_id
            JOIN food_sub_categ AS fsc ON orders.fsub_categ_id = fsc.fsub_categ_id
            WHERE 
                orders.payment = 0 AND 
                orders.custormer_id = ? AND 
                orders.order_date = CURDATE()
        ";
    
        $cartItems = DB::select($query, [$cid]);
    
        // Calculate total price
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            // Strip out non-numeric characters (e.g., £) and convert to float
            $price = (float) preg_replace('/[^\d\.]/', '', $item->up);  // Removes any non-numeric characters except for the decimal point
            $totalAmount += $price;
        }
    
        return view('cart.index', compact('cartItems', 'totalAmount', 'cid'));
    }

    public function remove($id)
    {
        $cid = session('cid'); 

        DB::table('orders')
            ->where('custormer_id', $cid)
            ->where('fitem_id', $id)
            ->where('payment', 0)
            ->whereRaw('order_date = CURDATE()')
            ->delete();

        return redirect()->route('cart.view')->with('success', 'Item removed from cart!');
    }
}
