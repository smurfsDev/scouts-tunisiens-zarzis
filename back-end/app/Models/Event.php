<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date_debut',
        'date_fin',
        'troupe_id',
        'type',
        'status',
        'organisateur_id'
    ];
}
