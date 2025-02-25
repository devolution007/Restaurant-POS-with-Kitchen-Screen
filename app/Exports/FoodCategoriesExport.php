<?php

namespace App\Exports;

use App\Models\FoodCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FoodCategoriesExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'name',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return FoodCategory::all()->makeHidden([
            'id',
            'uuid',
            'image',
            'created_at',
            'updated_at',
        ]);
    }
}
