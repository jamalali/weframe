<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
	
	protected $fillable = [
        'order_type_id',
        'customer_id',
        'total',
        'payment_method_id',
    ];
	
	public function lines() {
        return $this->hasMany('App\Models\Line');
    }
}