<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function companies()
    {
        return $this->morphedByMany('App\Models\Company', 'categorizable');
    }
}
