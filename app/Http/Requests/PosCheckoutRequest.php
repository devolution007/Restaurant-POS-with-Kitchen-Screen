<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosCheckoutRequest extends FormRequest
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
            'items' => 'required',
            'discount_rate' => 'required',
            'discount_amount' => 'required',
            'tax_amount' => 'required',
            'tax' => 'required',
            'profit_after_all' => 'required',
            'payable_after_all' => 'required',
            'payment_note' => 'sometimes',
            'staff_note' => 'sometimes',
            'payment_method_id' => 'required',
        ];
    }
}
