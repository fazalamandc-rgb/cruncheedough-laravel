<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Use DB facade to interact with the database

class FoodController extends Controller
{
    // Method to fetch food items based on fsc_id and food_id
    public function getFoodItems(Request $request)
{
    $fscId = $request->input('fsc_id');
    $foodId = $request->input('food_id');
    
    // Check if the required parameters are provided
    if (!$fscId || !$foodId) {
        return response()->json(['error' => 'Invalid request'], 400);
    }

    // Fetch food items based on fsc_id and food_id, ensuring fitem_id is included
    $foodItems = DB::table('food_item')
        ->where('fsub_categ_id', $fscId)  // fsub_categ_id in food_item table
        ->where('food_id', $foodId)       // food_id in food_item table
        ->get();

    // Return the food items as a JSON response
    return response()->json($foodItems);
}
}
