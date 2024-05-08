<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartDeliveryController extends Controller
{
    public function index()
    {
        return view('cart.delivery');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'factural_name' => 'required|string',
            'factural_address' => 'required|string',
            'factural_postal_code' => 'required|string',
            'factural_city' => 'required|string',
            'factural_phone_number' => 'required|string',
            'billing_name' => 'required|string',
            'billing_address' => 'required|string',
            'billing_postal_code' => 'required|string',
            'billing_city' => 'required|string',
            'shippingType' => 'required|string|in:osobnyodber,zbox,kurier',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Session::put('delivery_info', [
            'factural_name' => $request->input('factural_name'),
            'factural_address' => $request->input('factural_address'),
            'factural_postal_code' => $request->input('factural_postal_code'),
            'factural_city' => $request->input('factural_city'),
            'factural_phone_number' => $request->input('factural_phone_number'),
            'billing_name' => $request->input('billing_name'),
            'billing_address' => $request->input('billing_address'),
            'billing_postal_code' => $request->input('billing_postal_code'),
            'billing_city' => $request->input('billing_city'),
        ]);

        Session::put('shippingType', $request->input('shippingType'));


        if ($request->input('shippingType') === 'osobnyodber') {
            $selectedStore = $request->input('selectedStore');
            Session::put('pickup_place', $selectedStore);
        } else {
            Session::forget('pickup_place');
        }

        return redirect()->route('payment.index');
    }
}
