<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErDatas extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock_name',
        'stock_price',
        'er_date',
        'er_type',
        'price_before',
        'price_after'
    ];
}
