<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Ingredient::count() === 0) {
            Ingredient::create(
                [
                    'name' => 'Egg',
                    'price' => 2,
                    'cost' => 1,
                    'quantity' => 200,
                    'unit' => 'cope',
                    'alert_quantity' => 20,
                ]
            );
            Ingredient::create(
                [
                    'name' => 'Milk',
                    'price' => 3,
                    'cost' => 2,
                    'quantity' => 500,
                    'unit' => 'ltr',
                    'alert_quantity' => 50,
                ]
            );

            Ingredient::create(
                [
                    'name' => 'Meat',
                    'price' => 4,
                    'cost' => 3,
                    'quantity' => 1000,
                    'unit' => 'kg',
                    'alert_quantity' => 70,
                ]
            );
            Ingredient::create(
                [
                    'name' => 'Chicken',
                    'price' => 3,
                    'cost' => 2,
                    'quantity' => 1000,
                    'unit' => 'kg',
                    'alert_quantity' => 70,
                ]
            );
            Ingredient::create(
                [
                    'name' => 'Oninon',
                    'price' => 2,
                    'cost' => 1,
                    'quantity' => 1000,
                    'unit' => 'kg',
                    'alert_quantity' => 3,
                ]
            );
            Ingredient::create(
                [
                    'name' => 'Potato',
                    'price' => 2,
                    'cost' => 1,
                    'quantity' => 10000,
                    'unit' => 'kg',
                    'alert_quantity' => 50,
                ]
            );
            Ingredient::create(
                [
                    'name' => 'Bread',
                    'price' => 1,
                    'cost' => 1,
                    'quantity' => 5000,
                    'unit' => 'piece',
                    'alert_quantity' => 10,
                ]
            );
            Ingredient::create(
                [
                    'name' => 'Katchup',
                    'price' => 1,
                    'cost' => 1,
                    'quantity' => 7000,
                    'unit' => 'pack',
                    'alert_quantity' => 100,
                ]
            );
        }
    }
}
