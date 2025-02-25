<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpensesExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'title',
            'amount',
            'description',
            'expense_type_id',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Expense::all()->makeHidden([
            'id',
            'created_at',
            'updated_at',
        ]);
    }
}
