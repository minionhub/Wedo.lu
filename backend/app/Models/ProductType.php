<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'desc'
    ];

    public function products() {
        return $this->hasMany('App\Product', 'product_type_id');
    }
}
