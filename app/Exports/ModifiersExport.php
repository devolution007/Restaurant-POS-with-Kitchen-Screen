<?php

namespace App\Exports;

use App\Models\Modifier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModifiersExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'title', 'price', 'cost',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Modifier::all()->makeHidden([
            'id',
            'created_at',
            'updated_at',
        ]);
    }
}
