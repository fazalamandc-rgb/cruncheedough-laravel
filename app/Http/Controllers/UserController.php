<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showUsers()
    {
     
       $users = DB::table('users')->get();
       //$users = DB::table('users')->find(1);
        return view('users.index', compact('users'));
       //DD($users);
    }
}

