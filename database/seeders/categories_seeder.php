<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class categories_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('field_categories')->insert([
            'name' => 'OPTION SIGNALS'
        ]);
        DB::table('field_categories')->insert([
            'name' => 'OPTION LEAP SIGNALS'
        ]);
        DB::table('field_categories')->insert([
            'name' => 'BRACK OUT STOCKS'
        ]);
        DB::table('field_categories')->insert([
            'name' => 'CLOSED POSITIONS'
        ]);
        DB::table('field_categories')->insert([
            'name' => 'CRYPTO SIGNALS'
        ]);
        DB::table('field_categories')->insert([
            'name' => 'NEWS LETTER'
        ]);
        DB::table('field_categories')->insert([
            'name' => 'EDUCATIONAL IDEAS'
        ]);
    }
}
