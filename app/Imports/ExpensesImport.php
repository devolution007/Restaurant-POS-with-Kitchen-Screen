<?php

namespace App\Imports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExpensesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Expense([
            'title' => $row['title'],
            'amount' => $row['amount'],
            'description' => $row['description'],
            'expense_type_id' => $row['expense_type_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:expense_types,title',
            'amount' => 'required',
            'expense_type_id' => 'required',
            'description' => 'sometimes',
        ];
    }
}
