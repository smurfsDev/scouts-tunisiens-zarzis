<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    use HasFactory;
    public $incrementing = true;

    public function troupe()
    {
        return $this->belongsTo(Troupe::class,'troupe_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function Responsability()
    {
        return $this->hasOne(Responsability::class,'id','responsability_id');
    }

}
