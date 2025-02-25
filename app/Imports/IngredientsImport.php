<?php

namespace App\Imports;

use App\Models\Ingredient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class IngredientsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Ingredient([
            'name' => $row['name'],
            'price' => $row['price'],
            'cost' => $row['cost'],
            'unit' => $row['unit'],
            'quantity' => $row['quantity'],
            'alert_quantity' => $row['alert_quantity'],
            'description' => $row['description'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:ingredients,name',
            'price' => 'required|numeric|gte:cost',
            'cost' => 'required',
            'quantity' => 'required',
            'alert_quantity' => 'required',
            'description' => 'sometimes',
        ];
    }
}
