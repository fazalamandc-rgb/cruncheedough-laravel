<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        // Fetch food categories
        $foodCategories = DB::table('food_categ')->get();
    
        // Retrieve session data for order_no, UserName, and cid
        $orderNo = session('order_no');
        $userName = session('UserName');
        $cid = session('cid');
    
        // Calculate the cart count
        $cartCount = 0; // Default cart count
        if ($cid) {
            $cartCount = DB::table('orders')
                ->where('payment', 0)
                ->where('custormer_id', $cid)
                ->whereDate('order_date', '=', now()->toDateString())
                ->distinct('fitem_id')
                ->count('fitem_id');
            session(['c' => $cartCount]); // Store in session
        }
    
        // Return the login view with all required data
        return view('login', [
            'food_categ' => $foodCategories,
            'order_no' => $orderNo,
            'user_name' => $userName,
            'cid' => $cid,
            'cart_count' => $cartCount,
        ]);
    }
    
    

    // Process login details
    public function processLog(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'textUser' => 'required|string|max:255',
            'txtid' => 'required|string|max:255',
        ]);
    
        $userName = $validatedData['textUser'];
        $uid = $validatedData['txtid'];
    
        // Fetch or create customer
        $customer = DB::table('customers')->where('customer_id', $uid)->first();
        if (!$customer) {
            DB::table('customers')->insert([
                'customer_id' => $uid,
                'customer_name' => $userName,
            ]);
            $customer = (object) ['customer_id' => $uid, 'customer_name' => $userName];
        }
    
        // Check or create order
        $order = DB::table('orders')
            ->where('custormer_id', $uid)
            ->whereDate('order_date', now())
            ->where('payment', 0)
            ->orderByDesc('order_id')
            ->first();
    
        $orderNo = $order ? $order->order_id : DB::table('orders')->whereDate('order_date', now())->max('order_id') + 1 ?? 1;
    
        // Calculate the cart count
        $cartCount = DB::table('orders')
            ->where('payment', 0)
            ->where('custormer_id', $uid)
            ->whereDate('order_date', '=', now()->toDateString())
            ->distinct('fitem_id')
            ->count('fitem_id');
    
        // Set session data
        session([
            'cid' => $customer->customer_id,
            'UserName' => $customer->customer_name,
            'c' => $cartCount, // Store cart count in session
            'order_no' => $orderNo,
        ]);
    
        // Fetch food categories
        $foodCategories = DB::table('food_categ')->get(); 
        // Get the redirect URL (if any) passed from the cart page
        $redirectUrl = $request->input('redirect_url', route('cart.view')); // Default to cart if no redirect URL is provided
        // Store the redirect URL in session (optional, for flexibility in handling other redirects)
        session(['redirect_url' => $redirectUrl]);
        // Return to login view with session data
        return view('login', [
            'food_categ' => $foodCategories,
            'order_no' => session('order_no'),
            'user_name' => session('UserName'),
            'cid' => session('cid'),
            'cart_count' => $cartCount,
        ]);
    }
    

    // Post-login handling and redirect
    public function postLogin(Request $request)
    {
        // Perform login logic here, such as authenticating the user
        // For now, we assume login is successful

        // Get the redirect URL stored in the session (or fallback to cart view)
        $redirectUrl = session('redirect_url', route('cart.view'));

        // Redirect to the intended URL after login
        return redirect($redirectUrl);
    }
}
