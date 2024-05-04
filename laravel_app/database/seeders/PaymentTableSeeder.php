<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'type' => 'osobne',
                'price' => 0,
            ],
            [
                'type' => 'dobierka',
                'price' => 1,
            ],
            [
                'type' => 'kartou',
                'price' => 0,
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}
