<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitorssignal extends Model
{
    use HasFactory;
    protected $fillable = [
        'count',
        'ip',
        'date',
    ];
}
