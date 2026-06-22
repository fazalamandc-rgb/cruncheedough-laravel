<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FscategorController extends Controller
{
    public function getFoodSubCategories($foodId)
    {
        // Fetch subcategories or items related to the given food category ID
        $subCategories = DB::table('food_sub_categ')->where('food_id', $foodId)->get();

        // Generate the <option> elements for the dropdown
        $options = '<option value="">Available Options</option>';
        foreach ($subCategories as $subCategory) {
            $options .= "<option value='{$subCategory->fsub_categ_id}'>{$subCategory->fs_descriptions}</option>";
        }

        // Return the options as a JSON response
        return response()->json($options);
    }
}
