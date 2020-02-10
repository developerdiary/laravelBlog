<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    protected $appends = ['editlink', 'label'];

    public function getEditlinkAttribute()
    {   
        $link = route('admin.tag.edit', $this->id);
        return $link;
    }
    public function getLabelAttribute()
    {   
        $label = $this->name;
        return $label;
    }

    public function post(){
        return $this->belongsToMany('App\Post', 'post_tags');
    }
}
