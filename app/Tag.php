<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    protected $appends = ['editlink'];

    public function getEditlinkAttribute()
    {   
        $link = route('admin.tag.edit', $this->id);
        return $link;
    }
}
