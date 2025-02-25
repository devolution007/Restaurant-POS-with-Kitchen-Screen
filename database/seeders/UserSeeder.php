<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() !== 0) {
            return;
        }
        User::create(
            [
                'name' => 'Devolution',
                'email' => 'admin@admin.com',
                'password' => bcrypt(12345678),
                'role_id' => 1,
            ]
        );
        User::create(
            [
                'name' => 'Harry',
                'email' => 'harry@app.com',
                'password' => bcrypt(12345678),
                'role_id' => 2,
            ]
        );
        User::create(
            [
                'name' => 'John doe',
                'email' => 'chef@app.com',
                'password' => bcrypt(12345678),
                'role_id' => 3,
            ]
        );
    }
}
