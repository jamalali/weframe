<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mount extends Model {
	
	use SoftDeletes;
	
	protected $dates = [
        'deleted_at'
    ];
	
	protected $fillable = [
        'name',
        'width',
        'height',
        'price',
		'oversized_width',
        'oversized_height',
        'oversized_price',
		'core_colour',
		'thickness'
    ];
	
	protected $attributes = [
		'oversized_width'	=> null,
        'oversized_height'	=> null,
        'oversized_price'	=> null,
    ];
	
	public function variants() {
		return $this->hasMany('App\Models\MountVariant');
	}
	
	public function getPriceInPounds($priceInPence) {
		$priceInPounds = $priceInPence / 100;
		return number_format($priceInPounds, 2);
	}
	
	public function hasJumbo() {
		return isset($this->oversized_width) && isset($this->oversized_height) && isset($this->oversized_price);
	}
}