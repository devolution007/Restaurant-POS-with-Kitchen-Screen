<?php

namespace App\Imports;

use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PaymentMethodsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PaymentMethod([
            'title' => $row['title'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:payment_methods,title',
        ];
    }
}
