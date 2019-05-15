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
	
	public function getItemParamsAttribute($value) {
        return json_decode($value);
    }
	
	public function getGlassSizeAttribute() {
		
		$mount		= $this->item_params->mount;
		$mount_type = $mount->type;
		
		$artwork_width	= $this->item_params->artworkWidth;
		$artwork_height = $this->item_params->artworkHeight;
		
		$glass_width		= $artwork_width;
		$glass_height		= $artwork_height;
		
		switch ($mount_type) {
			case 'single':
			case 'circular':
			case 'oval':
				$top_mount = $mount->top;
				
				$glass_width	= $artwork_width;
				$glass_height	= $artwork_height;
				
				if (is_numeric($top_mount->sizes->left))	{ $glass_width = $glass_width + $top_mount->sizes->left; }
				if (is_numeric($top_mount->sizes->right))	{ $glass_width = $glass_width + $top_mount->sizes->right; }
				
				if (is_numeric($top_mount->sizes->top))		{ $glass_height	= $glass_height + $top_mount->sizes->top; }
				if (is_numeric($top_mount->sizes->bottom))	{ $glass_height	= $glass_height + $top_mount->sizes->bottom; }
				
				break;
			
			case 'double':
				$top_mount		= $mount->top;
				$bottom_mount	= $mount->bottom;
				
				$glass_width	= $artwork_width + $top_mount->sizes->left + $top_mount->sizes->right + $bottom_mount->size * 2;
				$glass_height	= $artwork_height + $top_mount->sizes->top + $top_mount->sizes->bottom + $bottom_mount->size * 2;
				
				break;
			
			case 'multimount':
				
				break;
				
		}
		
		return $glass_width . ' x ' . $glass_height;
	}
}