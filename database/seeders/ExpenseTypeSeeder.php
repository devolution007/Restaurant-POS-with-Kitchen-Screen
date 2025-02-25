<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ExpenseType::count() === 0) {
            ExpenseType::create(
                [
                    'title' => 'Kitchen expense',
                ]
            );
            ExpenseType::create(
                [
                    'title' => 'Staff expense',
                ]
            );
            ExpenseType::create(
                [
                    'title' => 'Other expense',
                ]
            );
        }
    }
}
