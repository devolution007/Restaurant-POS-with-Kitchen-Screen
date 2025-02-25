<?php

namespace App\Models;

use dacoto\EnvSet\Facades\EnvSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'app_name',
        'app_address',
        'app_phone',
        'app_https',
        'app_url',
        'app_about',
        'app_date_format',
        'app_date_locale',
        'app_default_role',
        'app_background',
        'app_icon',
        'app_locale',
        'app_timezone', 'app_direction',
        'app_user_registration',

        'queue_connection',

        'mail_from_name',
        'mail_from_address',
        'mail_mailer',
        'mail_host',
        'mail_username',
        'mail_password',
        'mail_port',
        'mail_encryption',

        'mailgun_domain',
        'mailgun_endpoint',
        'mailgun_secret',

        'recaptcha_enabled',
        'recaptcha_public',
        'recaptcha_private',

        'currency_symbol',
        'currency_symbol_on_left',
        'tax_rate', 'is_vat',
        'is_tax_fix',
        'tax_id',
        'is_tax_included',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        /*
         * Register an updated model event with the dispatcher.
         *
         * @param \Closure|string $callback
         * @return void
         */
        self::updating(
            static function ($model) {
                $writeable = [
                    'app_url', 'app_name', 'app_https',
                    'app_timezone', 'app_locale', 'app_date_format',
                    'mail_from_address', 'mail_from_name',
                    'mail_mailer', 'mail_encryption',
                    'mail_host', 'mail_password',
                    'mail_port', 'mail_username',
                    'queue_connection',
                    'mailgun_domain', 'mailgun_secret',
                    'mailgun_endpoint', 'app_direction',
                ];

                $writeable = collect($model)->only($writeable)->all();
                foreach ($writeable as $key => $value) {
                    EnvSet::setKey(strtoupper($key), $value);
                    EnvSet::save();
                }
            }
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'app_user_registration' => 'boolean',
        'recaptcha_enabled' => 'boolean',
        'app_https' => 'boolean',
        'sub_wid_is_flex' => 'boolean',
        'sub_wid_phone_input' => 'boolean',
        'sub_wid_email_input' => 'boolean',
        'currency_symbol_on_left' => 'boolean',
        'is_fix' => 'boolean',
        'is_vat' => 'boolean',
        'is_tax_fix' => 'boolean',
        'is_tax_included' => 'boolean',
    ];

    /**
     * Application icon URL
     *
     * @param mixed $icon icon
     *
     * @return string
     */
    public function getAppIconAttribute($icon): string
    {
        return $icon
        ? Storage::disk('public')->url($icon)
        : asset('images/default/icon.png');
    }

    /**
     * Application background image URL
     *
     * @param mixed $background background
     *
     * @return string
     */
    public function getAppBackgroundAttribute($background): string
    {
        return $background
        ? Storage::disk('public')->url($background)
        : asset('images/default/background.png');
    }
}
