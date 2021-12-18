<?php

namespace App\Imports;

use App\Models\FieldData;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;

class FieldsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FieldData([
            //
            "posted_date" => $row[0], 
            "buy_date" => $row[1], 
            "symbol" => $row[2], 
            "qty" => $row[3], 
            "expiration_date" => $row[4], 
            "sell_date" => $row[5], 
            "call_put_strategy" => $row[6], 
            "strike" => $row[7],  
            "strike_price" => $row[8], 
            "in_price" => $row[9], 
            "out_price" => $row[10], 
            "net_difference" => $row[11], 
            "high_price" => $row[12], 
            "percentage" => $row[13], 
            "status" => $row[14], 
            "category"=> $row[15], 
            "activated"=> $row[16], 
        ]);
    }
}
