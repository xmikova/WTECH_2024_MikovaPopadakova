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
        // Fetch payment methods from the database
        $payments = Payment::all();
        $totalPrice = $this->calculatePrice();

        // Pass the payment methods to the view
        return view('cart.payment', compact('payments', 'totalPrice'));
    }

    public function order(Request $request)
    {
        // Retrieve data from the session
        $deliveryInfo = Session::get('delivery_info');
        $cartItems = Session::get('cart', []);
        $paymentType = $request->input('paymentType');
        $deliveryType = Session::get('shippingType');
        $selectedStore = Session::get('pickup_place');

        // Create or retrieve customer info
        if (Auth::check()) {
            $customerId = Auth::id(); // Get the ID of the authenticated user
            $customerInfo = new CustomerInfo($deliveryInfo);
            $customerInfo->user_id = $customerId; // Set the user_id attribute
            $customerInfo->save();
        } else {
            // If user is not logged in, create a new customer info record
            $customerInfo = new CustomerInfo($deliveryInfo);
            $customerInfo->save();
        }

        $delivery = Delivery::where('type', $deliveryType)->firstOrFail();

        // Find the payment method based on the selected type
        $payment = Payment::where('type', $paymentType)->firstOrFail();

        // Create shopping cart and associate cart items
        // Create a new shopping cart instance
        $cart = new ShoppingCart();
        $cart->save(); // Save the shopping cart to generate an ID

        // Associate the shopping cart with the cart items
        // Create cart items and associate them with the shopping cart
        foreach ($cartItems as $item) {
            $cartItem = new CartItem([
                'product_id' => $item['product_id'],
                'amount' => $item['amount'],
            ]);
            $cart->items()->save($cartItem);
        }

        // Calculate total price from cart items
        $totalProductPrice = 0;
        foreach ($cartItems as $item) {
            // Retrieve the product price
            $product = Product::find($item['product_id']);
            if ($product) {
                $totalProductPrice += $product->price * $item['amount'];
            }
        }

        $deliveryFee = $delivery->price;
        $paymentFee = $payment->price;
        $totalPrice = $totalProductPrice + $deliveryFee + $paymentFee;

        // Create the order record
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

        // Clear the session data
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
        // Retrieve the order from the database
        $order = Order::findOrFail($orderId);

        // Pass the order data to the thank you view
        return view('thankyou', compact('order'));
    }

    private function calculatePrice()
    {
        // Retrieve data from the session
        $deliveryType = Session::get('shippingType');
        $cartItems = Session::get('cart', []);

        $totalProductPrice = 0;
        $deliveryFee = 0;
        $paymentFee = 0;

        // Calculate total product price
        foreach ($cartItems as $item) {
            // Retrieve the product price
            $product = Product::find($item['product_id']);
            if ($product) {
                $totalProductPrice += $product->price * $item['amount'];
            }
        }

        // Calculate delivery fee
        $delivery = Delivery::where('type', $deliveryType)->first();
        if ($delivery) {
            $deliveryFee = $delivery->price;
        }

        // Calculate payment fee (assuming you have a fixed payment fee)
        $payment = Payment::where('type', 'payment_type')->first();
        if ($payment) {
            $paymentFee = $payment->price;
        }

        // Calculate total price
        $totalPrice = $totalProductPrice + $deliveryFee + $paymentFee;

        // Return prices as an associative array
        return $totalPrice;

    }
}
