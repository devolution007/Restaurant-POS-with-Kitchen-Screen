<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingSubscriptionWidgetSetupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sub_wid_is_flex' => 'required|boolean',
            'sub_wid_css' => 'nullable',
            'sub_wid_title' => 'required',
            'sub_wid_sub_title' => 'required',
            'sub_wid_button_label' => 'required',
            'sub_wid_button_css' => 'nullable',
            'sub_wid_phone_input' => 'required|boolean',
            'sub_wid_email_input' => 'required|boolean',
        ];
    }
}
