<?php
namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $products = Product::paginate(20);

        return view('admin', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:256',
            'device_type' => 'sometimes|string|max:50',
            'description' => 'required|string|max:1000',
            'brand' => 'sometimes|string|max:50',
            'price' => 'sometimes|numeric',
            'weekly_hit' => 'sometimes|boolean',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'color' => 'sometimes|string|max:50',
            'image' => 'required|array|max:4',
            'image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->device_type = $request->device_type ?? '-';
        $product->description = $request->description;
        $product->brand = $request->brand ?? '-';
        $product->price = $request->price ?? 0;
        $product->weekly_hit = $request->weekly_hit ?? false;
        $product->category_id = $request->category_id ?? 1;
        $product->color = $request->color ?? '-';

        $product->save();

        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $image)
            {
                $name = time().'_'.$image->getClientOriginalName();
                $image->move(public_path().'/images/products/', $name);
                $imagePath = 'images/products/' . $name;

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image_path = $imagePath;
                $productImage->save();
            }
        }

        return redirect()->route('admin')->with('success', 'Product created successfully.');
    }
}
