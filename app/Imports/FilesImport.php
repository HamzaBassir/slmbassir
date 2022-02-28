<?php

namespace App\Imports;

use App\Models\FileContent;
use Maatwebsite\Excel\Concerns\ToModel;

class FilesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FileContent([
            'ticker'     => $row[0],
            'name'     => $row[1],
            'sector'     => $row[2],
        ]);
    }
}
