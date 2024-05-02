<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('product', compact('product'));
    }

//    public function addToCart(Request $request, $productId)
//    {
//        $product = Product::findOrFail($productId);
//
//        if (Auth::check()) {
            // Get or create the user's shopping cart
//            $shoppingCart = ShoppingCart::firstOrCreate(['user_id' => auth()->id()]);
//
            // Create a cart item for the product
//            $cartItem = new CartItem([
//                'product_id' => $product->id,
//                'amount' => 1, // You can adjust the amount as needed
//                'added_at' => now(),
//            ]);

            // Add the cart item to the shopping cart
//            $shoppingCart->items()->save($cartItem);

//            return redirect()->back()->with('success', 'Product added to cart successfully.');
//        } else {
            // If the user is not logged in, use session to store the cart
//            $cart = Session::get('cart', []);

//            if (array_key_exists($productId, $cart)) {
                // Increment the quantity of the existing product in the cart
//                $cart[$productId]['quantity'] += $request->quantity ?? 1;
//            } else {
                // Add the product to the cart with the specified quantity
//                $cart[$productId] = [
//                    'product' => $product,
//                    'quantity' => $request->quantity ?? 1,
//                ];
//            }

            // Store the updated cart back into the session
//            Session::put('cart', $cart);

//            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
//        }
//
//    }

}
