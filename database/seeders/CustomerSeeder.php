<?php
namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Customer::count() === 0) {
            Customer::create(
                [
                    'uuid' => Str::orderedUuid(),
                    'name' => 'Walking Customer',
                ]
            );
        }
    }
}
