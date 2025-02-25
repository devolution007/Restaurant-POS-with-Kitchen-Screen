<?php

namespace App\Imports;

use App\Models\Modifier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ModifiersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Modifier([
            'title' => $row['title'],
            'price' => $row['price'],
            'cost' => $row['cost'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:modifiers,title',
            'price' => 'required|numeric|gte:cost',
            'cost' => 'required',
        ];
    }
}
