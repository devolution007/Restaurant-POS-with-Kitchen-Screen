<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            CustomerSeeder::class,
            ServiceTableSeeder::class,
            FoodCategorySeeder::class,
            IngredientSeeder::class,
            IngredientSeeder::class,
            PaymentMethodSeeder::class,
            ExpenseTypeSeeder::class,
        ]);
    }
}
