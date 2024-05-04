<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CustomerInfo;
use App\Models\Delivery;
use App\Models\Payment;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Retrieve cart ID (either from session or database)
        $cartId = Auth::check() ? Auth::user()->shoppingCart->id : Session::get('cart_id');

        // Retrieve customer info ID, delivery info ID, and payment info ID from session
        $customerInfoId = session()->get('customer_info_id');
        $deliveryInfoId = session()->get('delivery_info_id');
        $paymentInfoId = session()->get('payment_info_id');

        // Create order record
        $order = Order::create([
            'cart_id' => $cartId,
            'customer_info_id' => $customerInfoId,
            'delivery_info_id' => $deliveryInfoId,
            'payment_info_id' => $paymentInfoId,
            'totalPrice' => $this->calculateTotalPrice(),
            'createdAt' => now()->toDateTimeString(),
            'state' => 'pending', // Set the initial state of the order
        ]);

        // Clear session or shopping cart records
        if (!Auth::check()) {
            Session::forget('cart');
            Session::forget('cart_id');
            Session::forget('customer_info_id');
            Session::forget('delivery_info_id');
            Session::forget('payment_info_id');
        }

        // Redirect to confirmation page or show success message
        return redirect()->route('order.confirmation', $order->id);
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

