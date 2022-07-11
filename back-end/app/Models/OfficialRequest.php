<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'receiver',
        'user_id',
        'object',
        'content',
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
