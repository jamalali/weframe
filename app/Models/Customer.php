<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Customer extends Model {
    
	use Encryptable;
	
	protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
		'email',
        'phone_number',
        'accepts_marketing',
    ];
	
	protected $encryptable = [
        'first_name',
        'last_name',
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
	
	public function getNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}