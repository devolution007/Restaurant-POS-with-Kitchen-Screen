<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class AppComposer
{
    /**
     * Application configuration for injecting to views
     *
     * @param View $view view
     */
    public function compose(View $view)
    {
        $setting = $this->master();
        $view->with('fav_icon', $setting->app_icon)
            ->with(
                'app_data',
                [
                    'url' => url('/'),
                    'name' => $setting->app_name,
                    'phone' => $setting->app_phone,
                    'address' => $setting->app_address,
                    'portal_about' => $setting->app_about,
                    'register' => $setting->app_user_registration,
                    'icon' => $setting->app_icon,
                    'background' => $setting->app_background,
                    'recaptcha_enabled' => $setting->recaptcha_enabled,
                    'recaptcha_public' => $setting->recaptcha_public,
                    'meta_home_title' => $setting->meta_home_title,
                    'app_date_format' => $setting->app_date_format,
                    'app_date_locale' => $setting->app_date_locale,
                    'app_timezone' => $setting->app_timezone,
                    'currency_symbol' => $setting->currency_symbol,
                    'currency_symbol_on_left' => $setting->currency_symbol_on_left,
                    'tax_setup' => $this->getTaxConfig(),
                    'synchronizer_dispay' => config('laravel-translatable-string-exporter.synchronizer_state', false),
                    'is_demo_mode' => config('app.demo_mode'),
                    'admin_nav_links' => config('nav-links.admin'),
                    'version' => config('app.version'),
                    'printer' => $this->getPrinterConfig(),
                    'application_pack' => $this->getApplicationPack(),
                    'time_date_formats' => config('date-time.formats'),
                    'order_types' => $this->getOrderTypes(),
                    'app_direction' => config('app.direction', 'ltl'),
                ]
            );
    }

    protected function getPrinterConfig()
    {
        $config = $this->master();
        return [
            'font_family' => 'monospace',
            'font_size' => 11,
            'font_color' => '#000',
            'printer_width' => '100mm',
            'printer_height' => '150mm',
            'qr_code_size' => 100,
        ];
    }

    protected function getOrderTypes()
    {
        return [
            ['title' => __('Dining'), 'key' => 'dining'],
            ['title' => __('Pickup'), 'key' => 'pickup'],
            ['title' => __('Dilivery'), 'key' => 'dilivery'],
        ];
    }

    protected function getApplicationPack()
    {
        return config('app.pack', null);
    }

    protected function master()
    {
        return Setting::find(1);
    }

    protected function getTaxConfig()
    {
        $configs = $this->master();
        return [
            'rate' => $configs->tax_rate,
            'is_tax_fix' => $configs->is_tax_fix,
            'is_tax_included' => $configs->is_tax_included,
            'tax_id' => $configs->tax_id,
            'is_vat' => $configs->is_vat,
        ];
    }

}
