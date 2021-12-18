<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class fields_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('field_data')->insert([
            'posted_date' => '2021-10-01',
            'buy_date' => '2021-10-01',
            'symbol' => 'symbol1',
            'qty' => 'qty1',
            'expiration_date' => '2021-10-01',
            'call_put_strategy' => 'call',
            'strike' => '10',
            'strike_price' => '10',
            'in_price' => '10',
            'out_price' => '10',
            'net_difference' => 'difference',
            'percentage' => '100%',
            'status' => 'ok',
            'category' => 1
        ]);

        DB::table('field_data')->insert([
            'posted_date' => '2021-10-05',
            'buy_date' => '2021-10-05',
            'symbol' => 'symbol2',
            'qty' => 'qty1',
            'expiration_date' => '2021-10-05',
            'call_put_strategy' => 'call',
            'strike' => '10',
            'strike_price' => '10',
            'in_price' => '10',
            'out_price' => '10',
            'net_difference' => 'difference',
            'percentage' => '100%',
            'status' => 'ok',
            'category' => 2
        ]);

        DB::table('field_data')->insert([
            'posted_date' => '2021-10-10',
            'buy_date' => '2021-10-10',
            'symbol' => 'symbol3',
            'qty' => 'qty1',
            'expiration_date' => '2021-10-10',
            'call_put_strategy' => 'call',
            'strike' => '10',
            'strike_price' => '10',
            'in_price' => '10',
            'out_price' => '10',
            'net_difference' => 'difference',
            'percentage' => '100%',
            'status' => 'ok',
            'category' => 3
        ]);
    }
}
