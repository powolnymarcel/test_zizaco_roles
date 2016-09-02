<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Post extends Model
{    

    protected $fillable = [
        'titre', 'contenu', 'user_id','uuid',
    ];

    public function user(){
       return  $this->belongsTo('App\User');
    }

    //A eviter ... Choisir un autre package
    public function setUuidAttribute($value)
    {
        $this->attributes['uuid'] = hex2bin(str_replace('-', '', $value));
    }

    public function getUuidAttribute($value)
    {
        return bin2hex($value);
    }

   public function scopeLaSelectionPerso($query){
       $locale= app()->getLocale();

       return $query->select('id','slug','titre_'.$locale.' as titre',
           'contenu_'.$locale.' as contenu','created_at as creation',
           'user_id','uuid','created_at as datecreation','image as image');

   }
    public function deAuteur(){
        return $this->belongsTo(User::class);
    }
    public function scopeIsLive($query){
        return $query->where('live',true);
    }
        //Un post à plusieur tag
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

}
