<?php

namespace App\Http\Controllers\Api\Locale;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LanguageToggleRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class LocaleController extends ApiController
{

    /**
     * Languages list
     *
     * @return JsonResponse
     */
    public function languageList(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::all()));
    }

    public function set(LanguageToggleRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $configs = $this->master();
        $configs->app_locale = $validated['locale'];
        $configs->app_direction = $validated['direction'];
        $configs->save();
        return response()->json(['message', 'Language has been changed']);
    }

    /**
     * Get locale
     *
     * @param string $locale locale
     *
     * @return JsonResponse
     */
    public function get(string $locale): JsonResponse
    {

        if (!$language = Language::where('locale', $locale)->first()) {
            return response()->json(
                ['message' => __('The selected language does not exist')],
                404
            );
        }

        $languageFile = base_path('resources/lang/' . $language->locale . '.json');

        if (File::exists($languageFile)) {
            return response()->json(
                json_decode(File::get($languageFile), true, 512, JSON_THROW_ON_ERROR)
            );
        }

        return response()->json(
            ['message' => __('The selected language does not exist')],
            404
        );
    }
}
