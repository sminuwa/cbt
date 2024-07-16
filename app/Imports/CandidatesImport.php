<?php

namespace App\Imports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CandidatesImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Candidate([
            'indexing' => $row['indexing'],
            'surname' => $row['surname'],
            'firstname' => $row['firstname'],
            'other_names' => $row['other_names'],
            'gender' => $row['gender'],
            'dob' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dob']),
            'programme_id' => $row['programme_id'],
            'lga_id' => $row['lga_id'],
            'country_id' => $row['country_id'],
            'exam_year' => $row['exam_year'],
            'password' => bcrypt($row['password']),
            'nin' => $row['nin'],
            'remember_token' => $row['remember_token'],
            'api_token' => $row['api_token'],
            'enabled' => $row['enabled'],
        ]);
    }
}
