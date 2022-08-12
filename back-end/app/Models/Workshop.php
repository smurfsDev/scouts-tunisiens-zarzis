<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'heure_debut',
        'heure_fin',
        'organisateur_id',
        'leader_id',
        'event_id',
        'description',
        'status',
    ];
}
