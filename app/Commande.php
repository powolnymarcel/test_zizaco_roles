<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
   
    public function user(){
        return $this->belongsTo('App\User');
    }

    //Une commande peut contenir plusieurs produits
    public function produits()
    {
        return $this->belongsToMany('App\Commande', 'commande_produit', 'produit_id', 'commande_id');
    }
}
