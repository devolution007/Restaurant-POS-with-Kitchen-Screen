<?php

namespace App\Imports;

use App\Models\FoodItem;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FoodItemsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new FoodItem(
            [
                'uuid' => Str::orderedUuid(),
                'sku' => $row['sku'],
                'name' => $row['name'],
                'price' => $row['price'],
                'discription' => $row['discription'] ?? null,
                'food_category_id' => $row['food_category_id'] ?? 1,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:food_items',
            'sku' => 'sometimes|unique:food_items',
            'price' => 'required|numeric|gte:cost',
            'category_id' => 'nullable',
            'description' => 'sometimes',
        ];
    }

}
