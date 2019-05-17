<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MountVariant extends Model {
	
	use SoftDeletes;
	
	protected $dates = [
        'deleted_at'
    ];
	
	protected $fillable = [
		'mount_id',
        'colour',
		'sku',
        'inventory',
        'price',
        'oversized_price',
    ];
	
	protected $attributes = [
        'inventory'	=> null,
        'price'		=> null
    ];
	
	protected $touches = ['mount'];
	
	public function mount() {
        return $this->belongsTo('App\Models\Mount');
    }
	
	public function getPriceInPounds($priceInPence) {
		$priceInPounds = $priceInPence / 100;
		return number_format($priceInPounds, 2);
	}
}