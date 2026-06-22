<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class FoodCateg extends Controller
{
    public function index()
    {
        // Fetch data from the `food_sub_categ` table
        $foods = DB::table('food_categ')->get();

        // Return the view with data
        return view('category-foods-desserts', compact('foods'));
    }

    public function edit(Request $request)
{
    // Fetch the record using the `DB` facade
    $food = DB::table('food_categ')->where('food_id', $request->id)->first();

    if (!$food) {
        return redirect()->back()->withErrors(['error' => 'Food category not found!']);
    }

    return view('edit-food1', compact('food'));
}

public function update(Request $request)
{
    // Validate the input
    $request->validate([
        'id' => 'required|integer|exists:food_categ,food_id',
        'Descriptions' => 'required|string|max:255',
    ]);

    // Update the record using the `DB` facade
    DB::table('food_categ')
        ->where('food_id', $request->id)
        ->update(['Descriptions' => $request->Descriptions]);

    // Redirect to the view page with a success message
    return redirect('category-foods-desserts')->with('success', 'Food category updated successfully!');
}
public function destroy($id)
{
    // Delete the food category by its food_id
    DB::table('food_categ')->where('food_id', $id)->delete();

    // Redirect to the category foods page with success message
    return redirect('category-foods-desserts')->with('success', 'Food category deleted successfully!');
}


public function create()
{
    return view('create-food'); // Display the form view
}

public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'Descriptions' => 'required|string|max:255',
    ]);

    // Get the maximum food_id from the table and add 1
    $maxFoodId = DB::table('food_categ')->max('food_id');
    $newFoodId = $maxFoodId + 1;

    // Insert the new food category with the manually set food_id
    DB::table('food_categ')->insert([
        'food_id' => $newFoodId, // Manually setting the food_id
        'Descriptions' => $request->Descriptions,
    ]);

    // Redirect to the index page with success message
    return redirect()->route('foods.index')->with('success', 'New food category added successfully!');
}



}
