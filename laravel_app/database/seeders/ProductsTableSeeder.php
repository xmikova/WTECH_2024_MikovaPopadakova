<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phoneModels = ['iPhone 11', 'iPhone 12', 'Samsung Galaxy S20', 'Google Pixel 5', 'OnePlus 8'];
        $imagePaths = [
            'images/products/telefon/telefon_cierny.jpg',
            'images/products/telefon/telefon_modry.jpg',
            'images/products/telefon/telefon_oranzovy.jpg',
            'images/products/telefon/telefon_ruzovy.jpg',
            'images/products/telefon/telefon_zlty.jpg',
        ];
        $colors = ['cierna', 'modra', 'oranzova', 'ruzova', 'zlta'];

        // Get the category "Obaly na telefon"
        $category = Category::where('name', 'Obaly na telefon')->first();

        $colorIndex = 0; // Initialize color index

        foreach ($phoneModels as $model) {
            foreach ($imagePaths as $index => $imagePath) {
                // Ensure the color index doesn't exceed the number of colors
                $colorIndex = $colorIndex % count($colors);

                $product = Product::create([
                    'name' => $model . ' Case',
                    'description' => 'Protective case for ' . $model,
                    'brand' => 'Brand',
                    'device_type' => $model,
                    'color' => $colors[$colorIndex],
                    'price' => rand(20, 50), // Random price between 20 and 50
                    'amount' => rand(5, 20), // Random amount between 5 and 20
                    'image' => $imagePath,
                    'category_id' => 1
                ]);

                // Increment the color index for the next product
                $colorIndex++;
            }
        }
    }
}
