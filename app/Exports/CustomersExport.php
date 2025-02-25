<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'name',
            'phone',
            'email',
            'address',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::all()->makeHidden([
            'id',
            'uuid',
            'created_at',
            'updated_at',
        ]);
    }
}
