<?php

namespace App\Imports;

use App\Models\FoodCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FoodCategoriesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new FoodCategory([
            'name' => $row['name'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:food_categories,name',
        ];
    }
}
