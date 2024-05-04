<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartDeliveryController extends Controller
{
    public function index()
    {
        return view('cart.delivery');
    }

    public function storeDelivery(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'factural_name' => 'required|string|max:255',
            'factural_address' => 'required|string',
            'factural_postal_code' => 'required|string|max:10',
            'factural_city' => 'required|string|max:255',
            'factural_phone_number' => 'required|string|max:20',
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string',
            'billing_postal_code' => 'required|string|max:10',
            'billing_city' => 'required|string|max:255',
            'shippingType' => 'required|string|max:20', // Validate shipping type
        ]);

        // Save the delivery information to the database
        $customerInfo = CustomerInfo::create([
            'user_id' => Auth::id(), // If the user is logged in
            'factural_name' => $validatedData['factural_name'],
            'factural_address' => $validatedData['factural_address'],
            'factural_postal_code' => $validatedData['factural_postal_code'],
            'factural_city' => $validatedData['factural_city'],
            'factural_phone_number' => $validatedData['factural_phone_number'],
            'billing_name' => $validatedData['billing_name'],
            'billing_address' => $validatedData['billing_address'],
            'billing_postal_code' => $validatedData['billing_postal_code'],
            'billing_city' => $validatedData['billing_city'],
        ]);

        // Save the shipping type
        $delivery = Delivery::create([
            'type' =>  $validatedData['shippingType'],
        ]);

        // Store the IDs in the session for later retrieval in the OrderController
        session()->put('customer_info_id', $customerInfo->id);
        session()->put('delivery_info_id', $delivery->id);

        // Redirect the user to the payment page
        return redirect()->route('payment.index');
    }
}
