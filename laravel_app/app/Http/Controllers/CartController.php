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
            $cartItems = Session::get('cart', []);

            $cart = new ShoppingCart();
            $cart->setRelation('items', collect($cartItems));

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
                    'added_at' => now()->toDateTimeString(), // Convert Carbon instance to string
                ]);

                $shoppingCart->items()->save($cartItem);
            }
        } else {
            // If the user is not logged in, use session to store the cart item
            $cartItems = Session::get('cart', []);

            // Check if the product already exists in the cart
            $existingCartItemKey = null;
            foreach ($cartItems as $key => $cartItem) {
                if ($cartItem['product_id'] == $productId) {
                    $existingCartItemKey = $key;
                    break;
                }
            }

            if ($existingCartItemKey !== null) {
                // Increment the quantity of the existing product in the cart
                $cartItems[$existingCartItemKey]['amount'] += 1;
            } else {
                // Add the product to the cart with quantity 1
                $cartItems[] = [
                    'product_id' => $productId,
                    'amount' => 1,
                    'added_at' => now()->toDateTimeString(), // Convert Carbon instance to string
                ];
            }

            // Store the updated cart items back into the session
            Session::put('cart', $cartItems);
        }

        // Redirect back to the previous page
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, $productId)
    {
        if (Auth::check()) {
            // Retrieve the current quantity of the cart item
            $cartItem = CartItem::where('product_id', $productId)->first();

            if ($cartItem) {
                // Increment the quantity by one
                $cartItem->increment('amount');
            }
        } else {
            // If the user is not logged in, use session to store the cart item
            $cartItems = Session::get('cart', []);

            // Check if the product exists in the cart
            $existingCartItemKey = array_search($productId, array_column($cartItems, 'product_id'));

            if ($existingCartItemKey !== false) {
                // Increment the quantity of the existing product in the cart
                $cartItems[$existingCartItemKey]['amount'] += 1;

                // Store the updated cart items back into the session
                Session::put('cart', $cartItems);
            }
        }

        return redirect()->back();
    }
    public function remove(Request $request, $productId)
    {
        if (Auth::check()) {
            $cart = $this->getCart();
            $existingCartItem = $cart->items()->where('product_id', $productId)->first();

            if ($existingCartItem) {
                if ($existingCartItem->amount > 1) {
                    $existingCartItem->decrement('amount');
                } else {
                    $existingCartItem->delete();
                }
            }

            return redirect()->back();        } else {
            // If the user is not logged in, use session to store the cart item
            $cartItems = Session::get('cart', []);

            // Check if the product exists in the cart
            $existingCartItemKey = array_search($productId, array_column($cartItems, 'product_id'));

            if ($existingCartItemKey !== false) {
                if ($cartItems[$existingCartItemKey]['amount'] > 1) {
                    // Decrement the quantity of the existing product in the cart
                    $cartItems[$existingCartItemKey]['amount'] -= 1;
                } else {
                    // Remove the product from the cart
                    unset($cartItems[$existingCartItemKey]);
                }

                // Store the updated cart items back into the session
                Session::put('cart', $cartItems);
            }
        }

        return redirect()->back();
    }

    private function calculateTotalPrice($cartItems)
    {
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem['product_id']);
                $price = $product ? $product->price : 0;
                $totalPrice += $price * $cartItem['amount'];
            }
            return $totalPrice;
    }
}



