<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products
        $products = Product::all();

        // Return the view and pass products to it
        return view('products.index', compact('products'));
    }
}
