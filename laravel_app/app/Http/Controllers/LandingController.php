<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{

    public function getProductOfTheWeek()
    {
        // Retrieve the product of the week based on your criteria, such as the 'weekly_hit' attribute
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
