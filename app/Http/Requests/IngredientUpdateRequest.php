<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientUpdateRequest extends FormRequest
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
            'name' => 'required|unique:ingredients,name,' . $this->ingredient->id,
            'price' => 'required|numeric|gte:cost',
            'cost' => 'required',
            'quantity' => 'required',
            'alert_quantity' => 'required',
            'unit' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'price.gte' => __('Price must be equal or greater then cost'),
        ];
    }
}
