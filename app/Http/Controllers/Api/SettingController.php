<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SettingAppearanceRequest;
use App\Http\Requests\SettingGeneralRequest;
use App\Http\Requests\SettingLocalizationRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Resources\UserRoleResource;
use App\Models\Language;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends ApiController
{

    protected $settings;

    protected $collection;

    /**
     * Construct middleware and initialize master app settings
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(
            [
                'setGeneral',
                'setAppearance',
                'setLocalization',
            ]
        );
        $this->settings = $this->master();
        $this->collection = collect($this->settings);
    }

    /**
     * Gets the general.
     *
     * @return JsonResponse  The general.
     */
    public function getGeneral(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'app_url',
                    'app_name',
                    'app_https',
                    'app_address',
                    'app_phone',
                ]
            )
        );
    }

    /**
     * Sets the general.
     *
     * @param \App\Http\Requests\SettingGeneralRequest $general The general
     *
     * @return JsonResponse                              The json response.
     */
    public function setGeneral(SettingGeneralRequest $general): JsonResponse
    {
        $this->settings->update($general->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the appearance.
     *
     * @return JsonResponse  The appearance.
     */
    public function getAppearance(): JsonResponse
    {
        return response()->json(
            $this->collection->only(['app_icon', 'app_background'])
        );
    }

    /**
     * Sets the appearance.
     *
     * @param \App\Http\Requests\SettingAppearanceRequest $request The request
     *
     * @return JsonResponse                                 The json response.
     */
    public function setAppearance(SettingAppearanceRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if ($request->file('icon')) {
            $validated['app_icon'] = $request->file('icon')
                ->store('appearance/icon', 'public');
        }
        if ($request->file('background')) {
            $validated['app_background'] = $request->file('background')
                ->store('appearance/background', 'public');
        }
        $this->settings->update($validated);
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the localization.
     *
     * @return JsonResponse  The localization.
     */
    public function getLocalization(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'app_timezone',
                    'app_locale',
                    'app_date_locale',
                    'app_date_format',
                    'app_direction',
                ]
            )
        );
    }

    /**
     * Sets the localization.
     *
     * @param \App\Http\Requests\SettingLocalizationRequest $localRequest The local request
     *
     * @return JsonResponse                                   The json response.
     */
    public function setLocalization(SettingLocalizationRequest $localRequest): JsonResponse
    {

        $this->settings->update($localRequest->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * User roles list
     *
     * @return JsonResponse  The json response.
     */
    public function userRoles(): JsonResponse
    {
        return response()->json(UserRoleResource::collection(UserRole::all()));
    }

    /**
     * Languages list
     *
     * @return JsonResponse  The json response.
     */
    public function languages(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::all()));
    }

    /**
     * System optimizer
     *
     * @param Request $request The request
     *
     * @return JsonResponse  The json response.
     */
    public function optimize(Request $request): JsonResponse
    {
        switch ($request->action) {
            case 'optimize':
                \Artisan::call('optimize:clear');
                break;
            case 'cache':
                \Artisan::call('config:cache');
                \Artisan::call('config:clear');
                break;
            case 'storage_link':
                if (File::exists(public_path('/storage'))) {
                    File::delete(public_path('/storage'));
                }
                \Artisan::call('storage:link');
                break;
            case 'update':
                \Artisan::call('install:update');
                break;
            default:
                \Artisan::call('view:clear');
                break;
        }
        return response()->json(
            [
                'message' => __('System performed successfully'),
                'output' => \Artisan::output(),
            ]
        );
    }
}
