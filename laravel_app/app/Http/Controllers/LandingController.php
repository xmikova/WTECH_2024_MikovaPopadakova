<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{

    public function getProductOfTheWeek()
    {
        $productOfTheWeek = Product::where('weekly_hit', true)->first();

        return $productOfTheWeek;
    }

    public function index()
    {
        $randomProducts = Product::inRandomOrder()->limit(15)->get();
        $productOfTheWeek = $this->getProductOfTheWeek();
        return view('landing', compact('randomProducts', 'productOfTheWeek'));
    }
}
