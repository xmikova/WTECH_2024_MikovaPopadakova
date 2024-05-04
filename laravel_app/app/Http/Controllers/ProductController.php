<?php
namespace App\Http\Controllers;

use App\Models\Product;


class ProductController extends Controller
{
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('product', compact('product'));
    }

}
