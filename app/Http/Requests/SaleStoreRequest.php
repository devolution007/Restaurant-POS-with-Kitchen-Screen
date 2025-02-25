<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleStoreRequest extends FormRequest
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
        $data = [
            'order_type' => 'required',
            'customer_id' => 'required',
            'cart_total_cost' => 'required',
            'cart_total_items' => 'required',
            'cart_total_price' => 'required',
            'profit_after_all' => 'required',
            'items' => 'required',
            'tax' => 'required',
            'tax_amount' => 'required',
            'progress' => 'required',
            'payment_note' => 'sometimes',
            'staff_note' => 'sometimes',
            'note_for_chef' => 'sometimes',
        ];

        if (request('order_type') === 'dining') {
            $data['table_id'] = 'required|exists:service_tables,id';
        }

        return $data;
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => __('Customer is required'),
            'table_id.required' => __('Service table is required for dinning order'),
            'table_id.exists' => __('No user was found with this e-mail address'),
        ];
    }
}
