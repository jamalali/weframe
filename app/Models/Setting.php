<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $primaryKey = ['key', 'namespace'];
	
	public $incrementing = false;
	
    protected $fillable  = [
		'key',
		'value',
		'namespace'
	];
	
	public function getValueAttribute($value) {
        return json_decode($value);
    }
}