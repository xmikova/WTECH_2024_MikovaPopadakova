<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\CartItem;
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

        // Pass the payment methods to the view
        return view('cart.payment', compact('payments'));
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
        $totalPrice = collect($cartItems)->sum('price');


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

    public function showOrders()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve orders associated with the authenticated user
        $orders = Order::whereHas('customerInfo', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        //dd($orders);

        // Pass the orders to the view
        return view('profile.edit', ['orders' => $orders]);
    }

}
