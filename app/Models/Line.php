<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model {
    
	protected $table = 'order_lines';
	
	protected $fillable = [
        'order_id',
        'item_params',
        'qty',
        'total',
    ];
}