<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'textUser' => 'required|string|max:255',
            'txtid' => 'required|string|max:255',
        ]);

        // For now, just return a success message
        return back()->with('message', 'Login successful!');
    }
}

