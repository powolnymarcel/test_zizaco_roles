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
        return $this->belongsToMany('App\Produit', 'commande_produit', 'commande_id', 'produit_id');
    }
}
