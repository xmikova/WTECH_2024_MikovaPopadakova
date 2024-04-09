<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showByCategory($category)
    {
        $category = Category::where('name', $category)->firstOrFail(); // Assuming 'name' is the column storing category names
        $products = $category->products()->get();
        return view('products.category', compact('products', 'category'));
    }
}
