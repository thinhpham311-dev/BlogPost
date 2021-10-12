<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
	
	public function Post()
	{
		return $this->belongsTo('App\Post');
	}
	
	public function User()
	{
		return $this->belongsTo('App\User');
	}
}
