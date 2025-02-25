<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (PaymentMethod::count() === 0) {
            PaymentMethod::create(
                [
                    'title' => 'Cash',
                ]
            );
            PaymentMethod::create(
                [
                    'title' => 'Card proccessing',
                ]
            );
        }
    }
}
