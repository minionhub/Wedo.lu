<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Get the BlogPosts for the BlogTag.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
