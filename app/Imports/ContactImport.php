<?php

namespace App\Imports;

use App\Models\SendContact;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;

class ContactImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SendContact([
            //
            'first_name' => $row[0],
            'last_name' => $row[1],
            'email' => $row[2],
            'telegram_id' => $row[3],
            'discord_id' => $row[4],
            'twitter_id' => $row[5],
            'slack_id' => $row[6],
            'phone' => $row[7],
        ]);
    }
}
