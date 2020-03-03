<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $with = ['tag', 'category', 'gallery'];

    protected $appends = ['editlink'];

    public function getEditlinkAttribute()
    {   
        $link = route('admin.post.edit', $this->id);
        return $link;
    }


    public function tag(){
        return $this->belongsToMany('App\Tag', 'post_tags')->withTimestamps();
    }

    public function category(){
        return $this->belongsToMany('App\Category', 'post_category')->withTimestamps();
    }

    
    public function gallery(){
        return $this->morphMany('App\Gallery', 'gallerytable');
    }
}
