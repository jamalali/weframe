<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Address extends Model {
   
	use Encryptable;
	
	protected $fillable = [
        'customer_id',
        'firstname',
        'surname',
        'address_1',
        'address_2',
        'town',
        'county',
        'postcode',
        'country_id',
        'phone_number',
    ];
	
	protected $encryptable = [
        'firstname',
        'surname',
        'address_1',
        'address_2',
        'town',
        'county',
        'postcode',
        'phone_number',
    ];
	
	public function getFillable() {
        return $this->fillable;
    }
}