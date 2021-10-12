<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $table = 'posts';
	protected $fillable = [
		'id',
        'taxonomy_id',
        'user_id',
        'post_title',
        'post_title_slug',
        'post_excerpt',
        'post_content',
        'post_views',
        'post_status',
        'comment_status'
	];
	public function Taxonomy()
	{
		return $this->belongsTo('App\Taxonomy');
	}

	public function User()
	{
		return $this->belongsTo('App\User');
	}

	public function Comment()
	{
		return $this->hasMany('App\Comment');
	}
}
