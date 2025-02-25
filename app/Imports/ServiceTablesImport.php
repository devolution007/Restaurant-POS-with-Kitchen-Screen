<?php

namespace App\Imports;

use App\Models\ServiceTable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ServiceTablesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ServiceTable([
            'title' => $row['title'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:service_tables,title',
        ];
    }
}
