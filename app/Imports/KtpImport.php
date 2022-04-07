<?php

namespace App\Imports;

use App\Models\Ktp;
use Maatwebsite\Excel\Concerns\ToModel;

class KtpImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Ktp([
            'nama' => $row[1],
            'tempat_lahir' => $row[2],
            'tanggal_lahir' => $row[3],
            'jenis_kelamin' => $row[4],
            'foto' => $row[5],
        ]);
    }
}
