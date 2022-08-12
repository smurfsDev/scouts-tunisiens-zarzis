<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function event()
    {
        return $this->belongsTo(Event::class);

    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id','id');
    }
}
