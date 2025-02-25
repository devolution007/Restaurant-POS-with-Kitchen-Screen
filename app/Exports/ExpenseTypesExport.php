<?php

namespace App\Exports;

use App\Models\ExpenseType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpenseTypesExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'title',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ExpenseType::all()->makeHidden([
            'id',
            'created_at',
            'updated_at',
        ]);
    }
}
