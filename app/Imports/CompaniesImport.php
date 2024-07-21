<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CompaniesImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

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

    public function rules(): array
    {
        return [
            '企業名' => ['required', Rule::unique('companies', 'name')],
            '郵便番号' => ['required'],
            '住所' => ['required'],
            '電話番号' => ['required'],
            '代表者名' => ['required'],
            '担当者名' => ['required'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '企業名.required' => '企業名は必須項目です。',
            '企業名.unique' => 'すでに登録されている企業名があります。',
            '郵便番号.required' => '郵便番号は必須項目です。',
            '住所.required' => '住所は必須項目です。',
            '電話番号.required' => '電話番号は必須項目です。',
            '代表者名.required' => '代表者名は必須項目です。',
            '担当者名.required' => '担当者名は必須項目です。',
        ];
    }
}
