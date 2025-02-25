<?php

namespace App\Exports;

use App\Models\FoodItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FoodItemsExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'sku',
            'name',
            'price',
            'description',
            'category_id',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return FoodItem::all()->makeHidden([
            'uuid',
            'id',
            'extras',
            'image',
            'created_at',
            'updated_at',
        ]);
    }
}
