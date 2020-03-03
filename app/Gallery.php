<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    protected $table = 'gallery';

    protected $fillable = [
        'name', 'type_id', 'gallerytable_type',
    ];
    
    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function gallerytable(){
        return $this->morphTo();
    }
}
