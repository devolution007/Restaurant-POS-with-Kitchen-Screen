<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMSNexmoGatewayRequest extends FormRequest
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
        if (request()->has('nexmo_status')) {
            return [
                'nexmo_status' => 'required',
                'nexmo_key' => 'required',
                'nexmo_secret' => 'required',
                'nexmo_from' => 'required',
            ];
        }

        return [
            'nexmo_status' => 'required',
        ];
    }
}
