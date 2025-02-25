<?php

namespace Database\Seeders;

use App\Models\ServiceTable;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ServiceTable::count() !== 0) {
            return;
        }
        ServiceTable::create(
            [
                'title' => 'Table one',
            ]
        );
        ServiceTable::create(
            [
                'title' => 'Table two',
            ]
        );
        ServiceTable::create(
            [
                'title' => 'Table three',
            ]
        );
        ServiceTable::create(
            [
                'title' => 'Table four',
            ]
        );
    }
}
