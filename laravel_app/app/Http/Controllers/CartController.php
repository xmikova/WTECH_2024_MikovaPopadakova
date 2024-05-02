<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    private function getCart()
    {
        if (Auth::check()) {
            return Auth::user()->shoppingCart;
        } else {
            $cart = Session::get('cart');

            // If $cart is null or not an instance of ShoppingCart, return a new instance
            if (!$cart instanceof ShoppingCart) {
                return new ShoppingCart();
            }

            return $cart;
        }
    }


    public function index()
    {
        $cart = $this->getCart();

        // Check if $cart is not null before accessing its properties
        $cartItems = $cart ? $cart->items : [];
        $totalPrice = $this->calculateTotalPrice($cartItems);

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }


    public function add(Request $request, $productId)
    {
        // Retrieve the product
        $product = Product::findOrFail($productId);

        if (Auth::check()) {
            // If the user is logged in, associate the product with the user's shopping cart
            $user = auth()->user();
            $shoppingCart = ShoppingCart::firstOrCreate(['user_id' => $user->id]);

            // Check if the product already exists in the user's cart
            $existingCartItem = $shoppingCart->items()->where('product_id', $productId)->first();

            if ($existingCartItem) {
                // Increment the quantity of the existing product in the cart
                $existingCartItem->increment('amount');
            } else {
                // Add the product to the cart with quantity 1
                $cartItem = new CartItem([
                    'product_id' => $product->id,
                    'amount' => 1,
                    'added_at' => now(),
                ]);

                $shoppingCart->items()->save($cartItem);
            }
        } else {
            // If the user is not logged in, use session to store the cart item
            $cartItem = Session::get('cart', []);

            // Check if the product already exists in the cart
            if (array_key_exists($productId, $cartItem)) {
                // Increment the quantity of the existing product in the cart
                $cartItem[$productId]['quantity'] += 1;
            } else {
                // Add the product to the cart with quantity 1
                $cartItem[$productId] = [
                    'product_id' => $productId,
                    'quantity' => 1,
                    'added_at' => now(),
                ];
            }

            // Store the updated cart item back into the session
            Session::put('cart', $cartItem);
        }


        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }


    public function update(Request $request, $productId)
    {
        // Retrieve the current quantity of the cart item
        $cartItem = CartItem::where('product_id', $productId)->first();

        if ($cartItem) {
            // Increment the quantity by one
            $cartItem->increment('amount');
        }

        return redirect()->back();
    }

    public function remove(Request $request, $productId)
    {
        $cart = $this->getCart();
        $existingCartItem = $cart->items()->where('product_id', $productId)->first();

        if ($existingCartItem) {
            if ($existingCartItem->amount > 1) {
                $existingCartItem->decrement('amount');
            } else {
                $existingCartItem->delete();
            }
        }

        return redirect()->back();
    }


    private function calculateTotalPrice($cartItems)
    {
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->amount;
        }
        return $totalPrice;
    }


}



