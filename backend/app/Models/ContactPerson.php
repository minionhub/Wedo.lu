<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Get the company that owns the ContactPerson.
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'listing_id');
    }

    /**
     * Get the jobOffer that owns the ContactPerson.
     */
    public function jobOffer()
    {
        return $this->belongsTo('App\JobOffer', 'listing_id');
    }
}
