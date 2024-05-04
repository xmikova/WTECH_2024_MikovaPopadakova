<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delivery;

class DeliveryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveries = [
            [
                'type' => 'osobnyodber',
                'price' => 0,
            ],
            [
                'type' => 'zbox',
                'price' => 3,
            ],
            [
                'type' => 'kurier',
                'price' => 3.50,
            ],
        ];

        foreach ($deliveries as $delivery) {
            Delivery::create($delivery);
        }
    }
}
