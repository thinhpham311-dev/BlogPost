<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomies extends Model
{
    protected $table = 'taxonomies';
    protected $fillable = [
         'taxonomy_name'
    ];
	public function Post()
	{
		return $this->hasMany('App\Post','taxonomy_id','id');
	}
}
