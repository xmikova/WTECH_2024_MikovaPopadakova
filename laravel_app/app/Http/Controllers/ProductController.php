<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class ProductController extends Controller
{
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('product', compact('product'));
    }

    /**
     * Update the specified product in the database.
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'color' => 'required|string|max:50',
            'brand' => 'required|string|max:50',
            'device_type' => 'required|string|max:50',
        ]);

        $product = Product::findOrFail($productId);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->color = $request->color;
        $product->brand = $request->brand;
        $product->device_type = $request->device_type;
        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product image.
     */
    public function deleteImage(Request $request, $productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = ProductImage::findOrFail($imageId);

        // Check if the image belongs to the product
        if ($image->product_id !== $product->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image file from storage
        Storage::delete($image->image_path);

        // Delete image record from database
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Upload a new product image.
     */
    public function uploadImage(Request $request, $productId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);

        if (!$request->hasFile('image')) {
            dd('No image file in request');
        }

        $file = $request->file('image');

        if (!$file->isValid()) {
            dd('File upload was not successful');
        }

        $product = Product::findOrFail($productId);

        // Check if the product already has 4 images
        if ($product->images()->count() >= 4) {
            throw ValidationException::withMessages(['image' => 'Produkt nesmie presiahnuť maximum povolených obrázkov - 4.']);
        }

        // Generate a unique file name
        $fileName = md5($file->getClientOriginalName()) . date('Y_m_d_H_i_s') . '.' . $file->getClientOriginalExtension();

        // Move the file to the public/images directory
        $file->move(public_path('images/products/'), $fileName);

        $imagePath = 'images/products/' . $fileName;

        $productImage = new ProductImage();
        $productImage->product_id = $product->id;
        $productImage->image_path = $imagePath;
        $productImage->save();

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }

    public function delete(Product $product)
    {

        // Delete each associated image file
        foreach ($product->images as $image) {
            // Construct the full path to the image file
            $imagePath = public_path($image->image_path);

            // Check if the image file exists
            if (file_exists($imagePath)) {
                // Delete the image file
                unlink($imagePath);
            }

            // Delete the image record from the database
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin')->with('success', 'Product and its images deleted successfully.');
    }
}
