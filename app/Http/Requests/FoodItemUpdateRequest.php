<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodItemUpdateRequest extends FormRequest
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
            'name' => 'required|unique:food_items,name,' . $this->food_item->id,
            'food_category_id' => 'nullable',
            'sku' => 'sometimes|unique:food_items,name,' . $this->food_item->id,
            'cost' => 'required',
            'price' => 'required|numeric|gte:cost',
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
