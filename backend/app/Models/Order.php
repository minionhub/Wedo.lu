<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'user_id', 'product_id', 'count', 'total', 'subtotal', 'tax', 'first_renew', 'last_renew', 'expire',
        'payment_method_id', 'address_id', 'status'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function paymentMethod() {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
    }

    public function address() {
        return $this->belongsTo('App\Models\Address');
    }
}
