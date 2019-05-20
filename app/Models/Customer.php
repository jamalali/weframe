<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Customer extends Model {
    
	use Encryptable;
	
	protected $fillable = [
        'user_id',
        'firstname',
        'surname',
		'email',
        'phone_number',
    ];
	
	protected $encryptable = [
        'firstname',
        'surname',
        'email',
		'phone_number',
    ];
	
	public function getFillable() {
        return $this->fillable;
    }
	
	public function addresses() {
        return $this->hasMany('App\Models\Address');
    }
	
	public function orders() {
        return $this->hasMany('App\Models\Order');
    }
}