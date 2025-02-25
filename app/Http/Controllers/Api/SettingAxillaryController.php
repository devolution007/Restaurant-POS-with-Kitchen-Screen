<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\SettingController;
use App\Http\Requests\SettingAuthenticationRequest;
use App\Http\Requests\SettingCaptchaRequest;
use App\Http\Requests\SettingCurrencyRequest;
use App\Http\Requests\SettingOutgoingMailRequest;
use App\Http\Requests\SettingTaxRequest;
use Illuminate\Http\JsonResponse;

class SettingAxillaryController extends SettingController
{

    /**
     * Construct middleware and initialize master app settings
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(
            [
                'getAuthentication',
                'setOutgoingMail',
                'setLogging',
                'setCaptcha',
                'setCurrency',
                'setTax',
            ]
        );
        $this->settings = $this->master();
        $this->collection = collect($this->settings);
    }

    /**
     * Gets the authentication.
     *
     * @return JsonResponse  The authentication.
     */
    public function getAuthentication(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'app_user_registration', 'app_default_role',
                ]
            )
        );
    }

    /**
     * Sets the authentication.
     *
     * @param \App\Http\Requests\SettingAuthenticationRequest $request The request
     *
     * @return JsonResponse                                     The json response.
     */
    public function setAuthentication(SettingAuthenticationRequest $request): JsonResponse
    {
        $this->settings->update($request->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the outgoing mail.
     *
     * @return JsonResponse  The outgoing mail.
     */
    public function getOutgoingMail(): JsonResponse
    {
        return response()->json(
            ['data' => $this->collection->only(
                [
                    'mail_from_address',
                    'mail_from_name',
                    'mail_mailer',
                    'mail_encryption',
                    'mail_host',
                    'mail_password',
                    'mail_port',
                    'mail_username',
                    'mailgun_domain',
                    'mailgun_secret',
                    'mailgun_endpoint',
                    'queue_connection',
                ]
            ),
                'command_1' => '/usr/local/bin/php  ' . base_path() . '/artisan schedule:run >> /dev/null',
                'command_2' => '/usr/bin/php  ' . base_path() . '/artisan schedule:run >> /dev/null',
            ]
        );
    }

    /**
     * Sets the outgoing mail.
     *
     * @param \App\Http\Requests\SettingOutgoingMailRequest $outgoingMail The outgoing mail
     *
     * @return JsonResponse                                   The json response.
     */
    public function setOutgoingMail(SettingOutgoingMailRequest $outgoingMail): JsonResponse
    {
        $this->settings->update($outgoingMail->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the captcha.
     *
     * @return JsonResponse  The captcha.
     */
    public function getCaptcha(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'recaptcha_enabled', 'recaptcha_public', 'recaptcha_private',
                ]
            )
        );
    }

    /**
     * Sets the captcha.
     *
     * @param \App\Http\Requests\SettingCaptchaRequest $captcha The captcha
     *
     * @return JsonResponse                              The json response.
     */
    public function setCaptcha(SettingCaptchaRequest $captcha): JsonResponse
    {
        $this->settings->update($captcha->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the tax.
     *
     * @return     JsonResponse  The tax.
     */
    public function getTax(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'tax_rate', 'is_tax_fix', 'is_tax_included', 'tax_id', 'is_vat',
                ]
            )
        );
    }

    /**
     * Sets the tax.
     *
     * @param      \App\Http\Requests\SettingTaxRequest  $tax    The tax
     *
     * @return     JsonResponse                          The json response.
     */
    public function setTax(SettingTaxRequest $tax): JsonResponse
    {
        $this->settings->update($tax->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the currency.
     *
     * @return     JsonResponse  The currency.
     */
    public function getCurrency(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'currency_symbol_on_left', 'currency_symbol',
                ]
            )
        );
    }

    /**
     * Sets the currency.
     *
     * @param      \App\Http\Requests\SettingCurrencyRequest  $currency  The currency
     *
     * @return     JsonResponse                               The json response.
     */
    public function setCurrency(SettingCurrencyRequest $currency): JsonResponse
    {
        $this->settings->update($currency->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }
}
