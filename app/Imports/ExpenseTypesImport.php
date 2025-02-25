<?php

namespace App\Imports;

use App\Models\ExpenseType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExpenseTypesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ExpenseType([
            'title' => $row['title'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:expense_types,title',
        ];
    }
}
