<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
        $imagePathsPhone = [
            'images/products/telefon/telefon_cierny.jpg',
            'images/products/telefon/telefon_modry.jpg',
            'images/products/telefon/telefon_oranzovy.jpg',
            'images/products/telefon/telefon_ruzovy.jpg',
            'images/products/telefon/telefon_zlty.jpg',
        ];
        $colorsPhone = ['cierna', 'modra', 'oranzova', 'ruzova', 'zlta'];

        $colorIndex = 0;

        foreach ($phoneModels as $model) {
            foreach ($imagePathsPhone as $index => $imagePath) {
                $colorIndex = $colorIndex % count($colorsPhone);

                $product = Product::create([
                    'name' => $model . ' obal',
                    'description' => 'Ochranný obal pre ' . $model,
                    'brand' => $model,
                    'device_type' => $model,
                    'color' => $colorsPhone[$colorIndex],
                    'price' => rand(20, 50),
                    'image' => $imagePath,
                    'category_id' => 1
                ]);

                for ($i = 0; $i < 4; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                    ]);
                }

                $colorIndex++;
            }
        }

        $headphoneModels = ['Apple Airpods 1', 'Apple Airpods 2', 'Samsung Galaxy Buds 1', 'Apple Airpods Max', 'Xiaomi Redmi Buds'];
        $imagePathsHeadphones = [
            'images/products/sluchadla/sluchadla_cervene.jpg',
            'images/products/sluchadla/sluchadla_cierne.jpg',
            'images/products/sluchadla/sluchadla_cierne_koza.jpg',
            'images/products/sluchadla/sluchadla_hnede_koza.jpg',
        ];
        $colorsHeadphones = ['cervena', 'cierna', 'cierna koza', 'hneda koza'];

        $colorIndex = 0;

        foreach ($headphoneModels as $model) {
            foreach ($imagePathsHeadphones as $index => $imagePath) {
                $colorIndex = $colorIndex % count($colorsHeadphones);

                $product = Product::create([
                    'name' => $model . ' obal',
                    'description' => 'Ochranný obal pre ' . $model,
                    'brand' => $model,
                    'device_type' => $model,
                    'color' => $colorsHeadphones[$colorIndex],
                    'price' => rand(20, 50),
                    'image' => $imagePath,
                    'category_id' => 2
                ]);

                for ($i = 0; $i < 4; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                    ]);
                }

                $colorIndex++;
            }
        }

        $product = Product::find(11);
        if ($product) {
            $product->update(['weekly_hit' => true]);
        }
    }
}
