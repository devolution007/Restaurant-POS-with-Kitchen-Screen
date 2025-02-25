<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (UserRole::count() !== 0) {
            return;
        }
        UserRole::create(
            [
                'name' => 'Admin',
                'is_primary' => true,
                'permissions' => [], //has all permissions
            ]
        );
        UserRole::create(
            [
                'name' => 'Order taker',
                'is_primary' => false,
                'permissions' => ['pos_portal'],
            ]
        );
        UserRole::create(
            [
                'name' => 'Chef',
                'is_primary' => false,
                'permissions' => ['kitchen_portal'],
            ]
        );
        UserRole::create(
            [
                'name' => 'Biller',
                'permissions' => ['pos_portal', 'order_checkout'],
            ]
        );
        UserRole::create(
            [
                'name' => 'Manager',
                'permissions' => [
                    'dashboard_access',
                    'overall_report',
                    'tax_report',
                    'expense_report',
                    'stock_alerts',
                ],
            ]
        );
    }
}
