<?php

namespace App\Exports;

use App\Models\ServiceTable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceTablesExport implements FromCollection, WithHeadings
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
        return ServiceTable::all()->makeHidden([
            'id',
            'is_booked',
            'created_at',
            'updated_at',
        ]);
    }
}
