<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts(){
        //Eloquent va ajouter la forme pluriel à taggable
        return $this->morphedByMany(Post::class,'taggable');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
