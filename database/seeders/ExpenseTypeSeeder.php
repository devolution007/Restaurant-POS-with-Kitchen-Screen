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
                    'title' => 'Kichen expense',
                ]
            );
            ExpenseType::create(
                [
                    'title' => 'Human resource expense',
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
