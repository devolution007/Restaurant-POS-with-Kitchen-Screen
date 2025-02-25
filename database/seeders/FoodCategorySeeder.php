<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (FoodCategory::count() === 0) {
            FoodCategory::create(
                [
                    'name' => 'Chineses',
                ]
            );
            FoodCategory::create(
                [
                    'name' => 'Burgers',
                ]
            );

            FoodCategory::create(
                [
                    'name' => 'Fries',
                ]
            );
            FoodCategory::create(
                [
                    'name' => 'Pizza',
                ]
            );
            FoodCategory::create(
                [
                    'name' => 'Cofees',
                ]
            );
        }
    }
}
