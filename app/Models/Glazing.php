<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Glazing extends Model {
	
	use SoftDeletes;
	
	protected $dates = [
        'deleted_at'
    ];
	
	protected $fillable = [
        'name',
        'width',
        'height',
        'price',
		'exclude_online'
    ];

	protected $casts = [
        'exclude_online' => 'boolean',
    ];
	
	protected $attributes = [
        'exclude_online' => 0,
    ];
	
	public function getPriceInPounds($priceInPence) {
		$priceInPounds = $priceInPence / 100;
		return number_format($priceInPounds, 2);
	}
}