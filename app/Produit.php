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
}
