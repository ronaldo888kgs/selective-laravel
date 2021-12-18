<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMails extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'receivers', 
        'description', 
        'group_id'
        ];
}
