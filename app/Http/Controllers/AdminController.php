<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function authenticate(Request $request)
    {
        // Validate input
        $request->validate([
            'textUser' => 'required|string',
            'txtPwd' => 'required|string',
        ]);

        // Retrieve user credentials from the form
        $username = $request->input('textUser');
        $password = $request->input('txtPwd');

        // Query the database to find the user by username and password
        $user = DB::table('users')
            ->where('User_Name', '=', $username)
            ->where('Password', '=', $password)
            ->first();

        // Check if the user exists and return appropriate response
        if ($user) {
            // Set session variables
            Session::put('User_id', $user->User_Id);
            Session::put('admn', $user->Admin);
            Session::put('order_no', '');

            // Redirect to main page after successful login
            return redirect()->route('mainadm'); // Ensure you have the 'main' route defined in routes/web.php
        } else {
            // If no user is found, return an error
            return back()->withErrors(['Invalid username or password']);
        }
    }


    public function mainadm()
{
    return view('mainadm'); // Adjust the view name as needed
}

public function logout()
{
    // Clear the session
    Session::flush();

    // Redirect to login page
    return redirect()->route('login');
}




}
