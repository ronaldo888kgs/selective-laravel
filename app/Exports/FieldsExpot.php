<?php

namespace App\Exports;

use App\Models\FieldData;
use Maatwebsite\Excel\Concerns\FromCollection;

class FieldsExpot implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FieldData::all();
    }
}
