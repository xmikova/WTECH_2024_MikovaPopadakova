<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/landing');
    }

    public function showOrders()
    {
        $user = Auth::user();

        // Retrieve the orders of the authenticated user
        $orders = Order::whereHas('customerInfo', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Retrieve the cart_ids from the orders
        $cartIds = $orders->pluck('cart_id');

        $itemsByCartId = [];

        // Loop over each cart_id and execute the query
        foreach ($cartIds as $cartId) {
            $items = DB::table('cart_item_shopping_cart')
                ->where('shopping_cart_id', '=', $cartId - 1)
                ->join('cart_items', 'cart_item_shopping_cart.cart_item_id', '=', 'cart_items.id')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->select('products.*', 'cart_items.amount as quantity')
                ->get();

            // Group the items by cart_id
            $itemsByCartId[$cartId] = $items;
        }




        // Attach the items to the corresponding order
        foreach ($orders as $order) {
            $order->items = $itemsByCartId[$order->cart_id] ?? collect();
        }

        return view('profile.edit', ['orders' => $orders]);
    }
}
