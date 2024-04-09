<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $randomProducts = Product::inRandomOrder()->limit(15)->get();
        return view('landing', compact('randomProducts'));
    }
}
