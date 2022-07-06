<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'receiver',
        'object',
        'content',
    ];
}
