<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{

    protected $fillable = [
        'nom', 'description', 'prix','photo_id',
    ];

    public function photos(){
        return $this->hasMany('App\Photo');
    }
    
    //Un produit peut etre listé sur plusieurs commandes différentes
    public function commandes()
    {
        return $this->belongsToMany('App\Commande', 'commande_produit', 'commande_id', 'produit_id');
    }
   //public function commandes(){
   //    return $this->hasMany('App\Commande');
   //}
}
