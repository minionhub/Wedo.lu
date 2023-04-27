<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Get the User that owns the Address.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the Company that owns the Address.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'listing_id');
    }

    /**
     * Get the Order that uses the Address.
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
