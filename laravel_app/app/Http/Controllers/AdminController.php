<?php
namespace App\Http\Controllers;

use App\Models\User;
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

    public function update(Request $request, Product $product)
    {
        // Check if the user is authorized to update the product (only admin can update)
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            // Add validation rules for other fields if needed
        ]);

        // Update the product with the validated data
        $product->update($validatedData);

        // Redirect back to the product details page with a success message
        return redirect()->back()->with('success', 'Product updated successfully.');
    }
}
