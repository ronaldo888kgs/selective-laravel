<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldData extends Model
{
    use HasFactory;
    protected $fillable = [
        'posted_date', 'description'
      ];
}
