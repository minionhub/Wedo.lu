<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'product_type_id', 'cycle', 'desc', 'items', 'images', 'status'
    ];

    public function productType () {
        return $this->belongsTo('App\ProductType');
    }

    public function orders () {
        return $this->hasMany('App\Order');
    }
}
