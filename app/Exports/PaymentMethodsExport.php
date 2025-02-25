<?php

namespace App\Exports;

use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentMethodsExport implements FromCollection, WithHeadings
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
        return PaymentMethod::all()->makeHidden([
            'id',
            'created_at',
            'updated_at',
        ]);
    }
}
