<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('product', compact('product'));
    }


}
