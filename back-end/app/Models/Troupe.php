<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'gender',
        'age_range',
    ];
}
