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

        $cartItems = $cart ? $cart->items : [];
        $totalPrice = $this->calculateTotalPrice($cartItems);

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }


    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if (Auth::check()) {

            $user = auth()->user();
            $shoppingCart = ShoppingCart::firstOrCreate(['user_id' => $user->id]);

            $existingCartItem = $shoppingCart->items()->where('product_id', $productId)->first();

            if ($existingCartItem) {
                $existingCartItem->increment('amount');
            } else {
                $cartItem = new CartItem([
                    'product_id' => $product->id,
                    'amount' => 1,
                    'added_at' => now()->toDateTimeString(),
                ]);

                $shoppingCart->items()->save($cartItem);
            }
        } else {
            $cartItems = Session::get('cart', []);

            $existingCartItemKey = null;
            foreach ($cartItems as $key => $cartItem) {
                if ($cartItem['product_id'] == $productId) {
                    $existingCartItemKey = $key;
                    break;
                }
            }

            if ($existingCartItemKey !== null) {
                $cartItems[$existingCartItemKey]['amount'] += 1;
            } else {
                $cartItems[] = [
                    'product_id' => $productId,
                    'amount' => 1,
                    'added_at' => now()->toDateTimeString(),
                ];
            }

            Session::put('cart', $cartItems);
        }


        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, $productId)
    {
        if (Auth::check()) {
            $cartItem = CartItem::where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->increment('amount');
            }
        } else {
            $cartItems = Session::get('cart', []);

            $existingCartItemKey = array_search($productId, array_column($cartItems, 'product_id'));

            if ($existingCartItemKey !== false) {
                $cartItems[$existingCartItemKey]['amount'] += 1;

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

            return redirect()->back();
        } else {
            $cartItems = Session::get('cart', []);

            $existingCartItemKey = array_search($productId, array_column($cartItems, 'product_id'));

            if ($existingCartItemKey !== false) {
                if ($cartItems[$existingCartItemKey]['amount'] > 1) {
                    $cartItems[$existingCartItemKey]['amount'] -= 1;
                } else {
                    unset($cartItems[$existingCartItemKey]);
                }

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



