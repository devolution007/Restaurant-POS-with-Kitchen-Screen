<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Setting::count() !== 0) {
            return;
        }
        Setting::create(
            [
                'app_name' => 'Restaurant POS',
                'app_https' => false,
                'app_url' => config('app.url'),
                'app_phone' => '7866718114',
                'app_date_format' => 'd-m-Y H:s:i',
                'app_address' => '4466 Scheuvront Drive Centennial, CO 80112',
                'mail_from_name' => 'Boilerplate system',
                'mail_from_address' => 'set_your_mail@your_domain.com',
                'mail_mailer' => 'log',
                'mail_host' => '0.0.0.0',
                'mail_username' => null,
                'mail_password' => null,
                'mail_port' => 1025,
                'mail_encryption' => null,
                'tax_rate' => 17,
            ]
        );
    }
}
