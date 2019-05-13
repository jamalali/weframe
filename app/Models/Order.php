<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
	
	protected $fillable = [
        'type_id',
        'customer_id',
        'total',
        'payment_method_id',
    ];
	
	public function lines() {
        return $this->hasMany('App\Models\Line');
    }
}