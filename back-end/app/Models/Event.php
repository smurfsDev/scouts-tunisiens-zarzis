<?php

namespace App\Models;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'organisateur_id',
        'description',
    ];

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }
}
