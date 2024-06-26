<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompaniesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Company([
            'name' => $row['企業名'],
            'post_code' => $row['郵便番号'],
            'address' => $row['住所'],
            'tel' => $row['電話番号'],
            'ceo_name' => $row['代表者名'],
            'responsible_person_name' => $row['担当者名'],
            'note' => $row['備考'],
        ]);
    }
}
