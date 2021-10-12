<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session_User extends Model
{
    protected $table = 'session__users';
    protected $fillable = [
        'token',
        'refresh_token',
        'token_expried',
        'refresh_token_expried',
        'user_id',
    ];
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
