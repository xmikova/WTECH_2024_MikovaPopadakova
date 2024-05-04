<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class CartPaymentController extends Controller
{
    public function index()
    {
        return view('cart.payment');
    }

    public function storePayment(Request $request)
    {
        // Validate the form data
        $validatedPayment = $request->validate([
            'paymentType' => 'required|string',
        ]);

        // Save the payment information to the database
        $payment = Payment::create([
            'type' => $validatedPayment['payment_type'],
        ]);

        // Store the payment ID in the session for later retrieval in the OrderController
        session()->put('payment_info_id', $payment->id);

        // Redirect the user to the order confirmation page
        return redirect()->route('order.confirmation');
    }
}
