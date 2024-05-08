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

        if ($image->product_id !== $product->id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::delete($image->image_path);

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Upload a new product image.
     */
    public function uploadImage(Request $request, $productId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!$request->hasFile('image')) {
            dd('No image file in request');
        }

        $file = $request->file('image');

        if (!$file->isValid()) {
            dd('File upload was not successful');
        }

        $product = Product::findOrFail($productId);

        if ($product->images()->count() >= 4) {
            throw ValidationException::withMessages(['image' => 'Produkt nesmie presiahnuť maximum povolených obrázkov - 4.']);
        }

        $fileName = md5($file->getClientOriginalName()) . date('Y_m_d_H_i_s') . '.' . $file->getClientOriginalExtension();

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

        foreach ($product->images as $image) {
            $imagePath = public_path($image->image_path);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin')->with('success', 'Product and its images deleted successfully.');
    }
}
