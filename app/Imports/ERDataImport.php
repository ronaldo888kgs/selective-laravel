<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ErDatas;

class ERDataImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new ErDatas([
            'stock_name' => $row[1],
            'stock_price' => $row[2],
            'er_date' => $row[3],
            'er_type' => $row[4],
            'price_before' => $row[5],
            'price_after' => $row[6]   
        ]);
    }
}
