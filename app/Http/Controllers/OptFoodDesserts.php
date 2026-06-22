<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptFoodDesserts extends Controller
{
    public function index()
{
    // Fetch data from the `food_sub_categ` table
    $foods = DB::table('food_sub_categ')->get();

    // Return the correct view with data
    return view('food-sub-categ', compact('foods'));
}


    public function edit(Request $request)
    {
        // Fetch the record using the `DB` facade
        $food = DB::table('food_sub_categ')->where('fsub_categ_id', $request->id)->first();

        if (!$food) {
            return redirect()->back()->withErrors(['error' => 'Sub-category not found!']);
        }

        return view('edit-food2', compact('food'));
    }



    public function update(Request $request, $id)
    {
        // Validate the input (remove 'id' validation since it's coming from the route)
        $request->validate([
            'fs_descriptions' => 'required|string|max:45',
            'food_id' => 'required|integer|exists:food_categ,food_id',
        ]);
    
        // Update the record using the `DB` facade
        DB::table('food_sub_categ')
            ->where('fsub_categ_id', $id)
            ->update([
                'fs_descriptions' => $request->fs_descriptions,
                'food_id' => $request->food_id,
            ]);
    
        // Redirect to the view page with a success message
        return redirect('sub-category-foods-desserts')->with('success', 'Sub-category updated successfully!');
    }

    public function destroy($id)
    {
        // Delete the sub-category by its `fsub_categ_id`
        DB::table('food_sub_categ')->where('fsub_categ_id', $id)->delete();

        // Redirect to the sub-category foods page with a success message
        return redirect('sub-category-foods-desserts')->with('success', 'Sub-category deleted successfully!');
    }

    public function create()
    {
        return view('create-sub-food'); // Display the form view
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'fs_descriptions' => 'required|string|max:45',
            'food_id' => 'required|integer|exists:food_categ,food_id',
        ]);

        // Get the maximum `fsub_categ_id` from the table and add 1
        $maxSubFoodId = DB::table('food_sub_categ')->max('fsub_categ_id');
        $newSubFoodId = $maxSubFoodId + 1;

        // Insert the new sub-category with the manually set `fsub_categ_id`
        DB::table('food_sub_categ')->insert([
            'fsub_categ_id' => $newSubFoodId, // Manually setting the `fsub_categ_id`
            'fs_descriptions' => $request->fs_descriptions,
            'food_id' => $request->food_id,
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('subFoods.index')->with('success', 'New sub-category added successfully!');
    }
}
