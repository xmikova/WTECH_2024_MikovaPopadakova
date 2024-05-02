<?php

namespace App\Http\Controllers\Auth;

use App\Models\CartItem;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();
        $sessionCart = Session::get('cart', []);

        if (!empty($sessionCart)) {
            $shoppingCart = $user->shoppingCart;

            foreach ($sessionCart as $item) {
                $existingCartItem = $shoppingCart->items()->where('product_id', $item['product_id'])->first();

                if ($existingCartItem) {
                    $existingCartItem->increment('amount', $item['amount']);
                } else {
                    $cartItem = new CartItem([
                        'product_id' => $item['product_id'],
                        'amount' => $item['amount'],
                        'added_at' => now()->toDateTimeString(),
                    ]);
                    $shoppingCart->items()->save($cartItem);
                }
            }

            Session::forget('cart');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('landing', absolute: false));
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/landing');
    }
}
