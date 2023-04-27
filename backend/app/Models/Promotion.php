<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Promotion extends Listing
{
    use Sluggable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'listing_id';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the company that owns the promotion.
     */
    public function promotion()
    {
        return $this->belongsTo('App\Company', 'listing_id');
    }
}
