<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->id();
            $table->string('app_name')->default('Business Help desk');
            $table->string('app_address')->nullable();
            $table->string('app_phone')->nullable();
            $table->string('app_https')->nullable();
            $table->string('app_url');
            $table->string('app_date_format')->default('L');
            $table->string('app_date_locale')->default('en');
            $table->string('app_default_role')->default('2');
            $table->string('app_background')->nullable();
            $table->string('app_icon')->nullable();
            $table->string('app_locale')->default('en');
            $table->string('app_direction')->default('ltl');
            $table->string('app_timezone')->default('UTC');
            $table->boolean('app_user_registration')->default(false);
            //outgoing email
            $table->string('queue_connection')->default('sync');
            $table->string('mail_from_name')->default('Business Help desk');
            $table->string('mail_from_address')->nullable();
            $table->string('mail_mailer')->default('log');
            $table->string('mail_host')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_port')->default('2525');
            $table->string('mail_encryption')->nullable()->default('tls');
            $table->string('mailgun_domain')->nullable();
            $table->string('mailgun_endpoint')->nullable();
            $table->string('mailgun_secret')->nullable();
            //re captcha
            $table->boolean('recaptcha_enabled')->default(false);
            $table->string('recaptcha_public')->nullable();
            $table->string('recaptcha_private')->nullable();

            $table->float('tax_rate')->default(0);
            $table->boolean('is_tax_fix')->default(false);
            $table->boolean('is_vat')->default(false);
            $table->boolean('is_tax_included')->default(false);
            $table->string('tax_id')->nullable();

            $table->string('currency_symbol')->default('$');
            $table->boolean('currency_symbol_on_left')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
