<?php

namespace App\Http\Controllers\Orders\Lines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Glazing;
use App\Models\Mount;
use App\Models\Order;
use App\Models\Line;
use Illuminate\Support\Arr;
use App\Models\MountVariant;

class OrdersLinesController extends Controller {

    public function index() {
        $orders = Order::orderBy('id', 'desc')->get();
        
        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    public function create() {
		
		$mounts				= Mount::with('variants')->get();
		$glazings			= Glazing::all();
		$foam_boards		= config('pricing.foam_board');
		$moulds				= config('moulds');
		$order_types		= config('pricing.order_types');
		$fixings			= config('pricing.fixings');
		$artwork_mountings	= config('pricing.artwork_mountings');
		
		//dd($moulds);
		
		//$moulds = Arr::only($moulds, 'name');
		
		//dd($moulds);
		
        return view('orders.create', [
			'mounts'			=> $mounts,
			'glazings'			=> $glazings,
			'foam_boards'		=> json_encode($foam_boards),
			'moulds'			=> json_encode($moulds),
			'order_types'			=> json_encode($order_types),
			'fixings'			=> json_encode($fixings),
			'artwork_mountings'	=> json_encode($artwork_mountings)
		]);
    }

	public function show($order_id, $line) {
		
		$item_params = (array) $line->item_params;
		
		$artwork_description = Arr::pull($item_params, 'artworkDescription');
		
		$artwork_width	= Arr::pull($item_params, 'artworkWidth');
		$artwork_height = Arr::pull($item_params, 'artworkHeight');
		
		$mount			= Arr::pull($item_params, 'mount');
		$glazing_id		= Arr::pull($item_params, 'glazing');
		$moulding_id	= Arr::pull($item_params, 'moulding');
		$order_type_id	= Arr::pull($item_params, 'orderType');
		
		if ($mount->type == 'none') {
			$mount = false;
		} else {
			$mount->colours	= $this->getMountColours($mount);
		}
		
		$glazing	= $this->getGlazing($glazing_id);
		$moulding	= $this->getMoulding($moulding_id);
		$order_type	= $this->getOrderType($order_type_id);
		
		$siblings = Line::where('order_id', $order_id)->get();
		
		return view('orders.lines.show', [
            'line'					=> $line,
			'item_params'			=> $item_params,
			'artwork_description'	=> $artwork_description,
			'moulding'				=> $moulding,
			'mountboard'			=> $mount,
			'glazing'				=> $glazing,
			'siblings'				=> $siblings,
			'order_type'			=> $order_type
        ]);
    }
	
	private function getOrderType($id) {
		return config('pricing.order_types.' . $id);
	}
	
	private function getMountColours($mount) {
		$mount_type	= $mount->type;
		
		switch ($mount_type) {
			case 'single':
			case 'circular':
			case 'oval':
				$top_mount = $mount->top;
				$top_mount_colour_id = $top_mount->colour;
				
				return [
					'top' => MountVariant::find($top_mount_colour_id)
				];
			
			case 'double':
				$top_mount		= $mount->top;
				$bottom_mount	= $mount->bottom;
				
				$top_mount_colour_id	= $top_mount->colour;
				$bottom_mount_colour_id = $bottom_mount->colour;
				
				return [
					'top'		=> MountVariant::find($top_mount_colour_id),
					'bottom'	=> MountVariant::find($bottom_mount_colour_id)
				];
			
			case 'multimount':
				$num_apertures	= $mount->num_apertures;
				$mount_colour	= $mount->colour;
				
				return $mount_colour;
		}
	}
	
	private function getMoulding($moulding_id) {
		return config('moulds.' . $moulding_id);
	}
	
	private function getGlazing($glazing_id) {
		
		// Get the glazing information from the config file by way of the selected (2-part in some cases) ID
		$glazing_id_parts = explode('-', $glazing_id);
		
		$glazing_category = $glazing_id_parts[0];
		
		$glazing = config('glazings.' . $glazing_category);
		
		if (isset($glazing['options'])) {
			
			// If glazing catgory has options the option should have been selected
			
			if (isset($glazing_id_parts[1])) {
				$glazing_option = $glazing_id_parts[1];
				$glazing = $glazing['options'][$glazing_option];
			}
		}
		
		return $glazing;
	}
}