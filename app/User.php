<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
class User extends Authenticatable
{

    use EntrustUserTrait; // add this trait to your user model

    public function commandes(){
        return $this->hasMany('App\Commande');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts(){
        return $this->hasMany('App\Post');
    }

    //Juste pour le test...
    public function nomEtEmail(){
        return $this->name . '< nom + email >' . $this->email;
    }

    public function avatar(){
        return 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=60&d=mm';
    }

}
