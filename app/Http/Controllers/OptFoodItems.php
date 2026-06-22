<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptFoodItems extends Controller
{
    // Display all food items
    public function index()
    {
        $foodItems = DB::table('food_item')->get();
        return view('food-items', compact('foodItems'));
    }

    // Display the form for creating a new food item
    public function create()
    {
        return view('create-food-item');
    }

    // Store a new food item
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'item_description' => 'required|string|max:200',
            'unit_price' => 'required|string|max:45',
            'fsub_categ_id' => 'required|integer|exists:food_sub_categ,fsub_categ_id',
            'food_id' => 'required|integer|exists:food_categ,food_id',
        ]);

        // Get the maximum `fitem_id` from the table and add 1
        $maxItemId = DB::table('food_item')->max('fitem_id');
        $newItemId = $maxItemId + 1;

        // Insert the new food item
        DB::table('food_item')->insert([
            'fitem_id' => $newItemId,
            'item_description' => $request->item_description,
            'unit_price' => $request->unit_price,
            'fsub_categ_id' => $request->fsub_categ_id,
            'food_id' => $request->food_id,
        ]);

        return redirect()->route('foodItems.index')->with('success', 'New food item added successfully!');
    }

    // Display a specific food item for editing
    public function edit($id)
    {
        $foodItem = DB::table('food_item')->where('fitem_id', $id)->first();

        if (!$foodItem) {
            return redirect()->back()->withErrors(['error' => 'Food item not found!']);
        }

        return view('edit-food-item', compact('foodItem'));
    }

    // Update a specific food item
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_description' => 'required|string|max:200',
            'unit_price' => 'required|string|max:45',
            'fsub_categ_id' => 'required|integer|exists:food_sub_categ,fsub_categ_id',
            'food_id' => 'required|integer|exists:food_categ,food_id',
        ]);

        DB::table('food_item')
            ->where('fitem_id', $id)
            ->update([
                'item_description' => $request->item_description,
                'unit_price' => $request->unit_price,
                'fsub_categ_id' => $request->fsub_categ_id,
                'food_id' => $request->food_id,
            ]);

        return redirect()->route('foodItems.index')->with('success', 'Food item updated successfully!');
    }

    // Delete a specific food item
    public function destroy($id)
    {
        DB::table('food_item')->where('fitem_id', $id)->delete();
        return redirect()->route('foodItems.index')->with('success', 'Food item deleted successfully!');
    }
}
