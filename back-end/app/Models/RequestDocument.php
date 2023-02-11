<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDocument extends Model
{
    use HasFactory;

	protected $fillable = [
		"title",
		"to",
		"date",
		"location",
		"subject",
		"body",
		"user_id",
		"admin_id",
		"status",
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}


	public function admin()
	{
		return $this->belongsTo(User::class);
	}

}
