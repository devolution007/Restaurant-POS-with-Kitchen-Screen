<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodItemStoreRequest extends FormRequest
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
            'name' => 'required|unique:food_items',
            'food_category_id' => 'nullable',
            'sku' => 'sometimes|unique:food_items',
            'cost' => 'required',
            'price' => 'required|gte:cost',
            'ingredients' => 'sometimes',
            'description' => 'sometimes',
        ];
    }

    public function messages(): array
    {
        return [
            'price.gte' => __('Price must be equal or greater then cost'),
        ];
    }
}
