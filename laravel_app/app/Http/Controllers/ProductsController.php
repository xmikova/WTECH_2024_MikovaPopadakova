<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function searchProducts(Request $request){
        $query = $request->input('query');

        $productsQuery = Product::query();

        if ($query) {
            $productsQuery->whereRaw("to_tsvector('english', name || ' ' || description || ' ' || device_type || ' ' || brand) @@ plainto_tsquery('english', ?) OR name ILIKE ?", [$query, '%' . $query . '%']);
        }


        $deviceTypes = Product::distinct()->pluck('device_type');

        // Retrieve unique colors from products
        $colors = Product::distinct()->pluck('color');

        $minPrice = $productsQuery->min('price');
        $maxPrice = $productsQuery->max('price');

        // Apply filters if provided in the request
        if ($request->has('device_type')) {
            $productsQuery->where('device_type', $request->input('device_type'));
        }

        if ($request->has('color')) {
            $productsQuery->where('color', $request->input('color'));
        }

        if ($request->has('min_price')){
            // Apply the filter only if min_price is not empty
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


        return view('products',compact('products', 'deviceTypes', 'colors', 'minPrice','maxPrice'));
    }
}
