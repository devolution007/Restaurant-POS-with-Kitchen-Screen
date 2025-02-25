<?php

namespace App\Exports;

use App\Models\Ingredient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IngredientsExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'name', 'price', 'cost', 'unit', 'quantity', 'alert_quantity', 'description',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Ingredient::all()->makeHidden([
            'id',
            'created_at',
            'updated_at',
        ]);
    }
}
