<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name', 'descriptions', 'parent_id',
    ];

    protected $appends = ['editlink', 'label'];

    public function getEditlinkAttribute()
    {   
        $link = route('admin.category.edit', $this->id);
        return $link;
    }

    public function getLabelAttribute()
    {   
        $label = $this->name;
        return $label;
    }

    public function children() {
        return $this->hasMany('App\Category','parent_id','id')->with('Children');
    }

    public function post(){
        return $this->belongsToMany('App\Post', 'post_category');
    }
}
