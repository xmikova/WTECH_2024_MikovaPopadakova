<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CartPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        $totalPrice = $this->calculatePrice();

        return view('cart.payment', compact('payments', 'totalPrice'));
    }

    public function order(Request $request)
    {
        $deliveryInfo = Session::get('delivery_info');
        $cartItems = Session::get('cart', []);
        $paymentType = $request->input('paymentType');
        $deliveryType = Session::get('shippingType');
        $selectedStore = Session::get('pickup_place');

        if (Auth::check()) {
            $customerId = Auth::id();
            $customerInfo = new CustomerInfo($deliveryInfo);
            $customerInfo->user_id = $customerId;
            $customerInfo->save();
        } else {
            $customerInfo = new CustomerInfo($deliveryInfo);
            $customerInfo->save();
        }

        $delivery = Delivery::where('type', $deliveryType)->firstOrFail();
        $payment = Payment::where('type', $paymentType)->firstOrFail();

        $cart = new ShoppingCart();
        $cart->save();

        foreach ($cartItems as $item) {
            $cartItem = new CartItem([
                'product_id' => $item['product_id'],
                'amount' => $item['amount'],
            ]);
            $cart->items()->save($cartItem);
        }

        $totalPrice = $this->calculatePrice();

        $order = new Order([
            'totalPrice' => $totalPrice,
            'createdAt' => now(),
            'state' => 'vytvorena',
        ]);

        if ($selectedStore) {
            $order->pickupPlace = $selectedStore;
        }

        $order->cart()->associate($cart);
        $order->customerInfo()->associate($customerInfo);
        $order->delivery()->associate($delivery);
        $order->payment()->associate($payment);
        $order->save();

        Session::forget('delivery_info');
        Session::put('cart', []);

        if (Auth::check()) {
            $user = Auth::user();
            $user->shoppingCart->user_id = null;
            $user->shoppingCart->save();
        }

        return Redirect::route('payment.thankyou', ['order_id' => $order->id]);
    }

    public function thankYou($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('thankyou', compact('order'));
    }

    public function showOrders()
    {
        $user = Auth::user();

        $orders = Order::whereHas('customerInfo', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();


        return view('profile.edit', ['orders' => $orders]);
    }

    private function calculatePrice()
    {
        $deliveryType = Session::get('shippingType');
        $cartItems = [];

        if (Auth::check()) {
            $user = Auth::user();

            $cartItems = $user->shoppingCart->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'amount' => $item->amount,
                ];
            })->toArray();
        } else {
            $cartItems = Session::get('cart', []);
        }

        $totalProductPrice = 0;
        $deliveryFee = 0;
        $paymentFee = 0;

        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $totalProductPrice += $product->price * $item['amount'];
            }
        }

        $delivery = Delivery::where('type', $deliveryType)->first();
        if ($delivery) {
            $deliveryFee = $delivery->price;
        }

        $payment = Payment::where('type', 'payment_type')->first();
        if ($payment) {
            $paymentFee = $payment->price;
        }

        $totalPrice = $totalProductPrice + $deliveryFee + $paymentFee;

        return $totalPrice;
    }

}
