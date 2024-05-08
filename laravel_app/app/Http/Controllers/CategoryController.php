<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function showByCategory(Request $request, $categoryName)
    {
        $category = Category::where('name', $categoryName)->firstOrFail();

        $productsQuery = Product::where('category_id', $category->id);

        $deviceTypes = Product::distinct()->pluck('device_type');

        $colors = Product::distinct()->pluck('color');

        $minPrice = $productsQuery->min('price');
        $maxPrice = $productsQuery->max('price');

        if ($request->has('device_type')) {
            $productsQuery->where('device_type', $request->input('device_type'));
        }

        if ($request->has('color')) {
            $productsQuery->where('color', $request->input('color'));
        }

        if ($request->has('min_price')){
            $productsQuery->whereRaw('CAST(price AS INTEGER) >= ?', [$request->input('min_price')]);
        }

        if ($request->has('max_price')) {
            $productsQuery->whereRaw('CAST(price AS INTEGER) <= ?', [$request->input('max_price')]);
        }

        if ($request->has('sort_by')) {
            switch ($request->input('sort_by')) {
                case 'lowest':
                    $productsQuery->orderBy('price', 'asc');
                    break;
                case 'highest':
                    $productsQuery->orderBy('price', 'desc');
                    break;
            }
        }

        $products = $productsQuery->paginate(20);

        return view('category', compact('products', 'category',  'deviceTypes', 'colors', 'minPrice','maxPrice'));
    }
}
