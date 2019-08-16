<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function searches() {
        return $this->hasMany('App\Search');
    }

    public function favorites() {
        return $this->hasMany('App\Favorite');
    }

    public function get_favorites() {
        if(!count($this->favorites))
            return [];

        $favorites = [];
        foreach($this->favorites as $f) {
            $favorites[] = $f->gif_id;
        }

        return $favorites;
    }
}
