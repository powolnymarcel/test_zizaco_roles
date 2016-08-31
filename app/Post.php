<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{    
    protected $guarded = ['id'];

    protected $fillable = [
        'titre', 'contenu', 'user_id','uuid',
    ];

    public function user(){
       return  $this->belongsTo('App\User');
    }


    public function setUuidAttribute($value)
    {
        $this->attributes['uuid'] = hex2bin(str_replace('-', '', $value));
    }

    public function getUuidAttribute($value)
    {
        return bin2hex($value);
    }
}
