<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request) {
		
		$settings = Cache::get('settings_pricing');
		
		$mould_cost		= $request->input('mould_cost');
		$mould_width	= $request->input('mould_width');
		
		$mount = json_decode($request->input('mount'));
		
		$glass_size_width		= $request->input('glass_size_width');
		$glass_size_height		= $request->input('glass_size_height');
		
		$mould_price = $this->getMouldPrice($glass_size_width, $glass_size_height, $mould_cost, $mould_width, $settings);
		
		$glass_price = $this->getGlassPrice($glass_size_width, $glass_size_height, $settings);
		
		return response()->json([
			'mould_price' => $mould_price,
			'glass_price' => $glass_price
		]);
    }
	
	private function getMouldPrice($glass_width, $glass_height, $mould_cost, $mould_width, $settings) {
		
		$mould_cut_wastage = $settings['mould_cut_wastage'];
		
		$total_length = $glass_width * 2 + $glass_height * 2 + $mould_width * 8;
		
		$total_mould_cost = ($mould_cost * $total_length) / 1000;
		
		$total_mould_cost_plus_wastage = $total_mould_cost + ($total_mould_cost / 100 * $mould_cut_wastage);
		
		return $total_mould_cost_plus_wastage;
	}
	
	private function getGlassPrice($frame_width, $frame_height, $settings) {
		
		$wastage	= $settings['glass_wastage'];
		$markup		= $settings['glass_markup'];
		
		// The glass sizes i.e. full, half & quarter
		$width_full		= $settings['standard_float_glass']['width'];
		$height_full	= $settings['standard_float_glass']['height'];
		$price_full		= $settings['standard_float_glass']['price'];
		
		// Cut the full size in her half to get the half size
		// We want to cut the long side not the short side
		if ($width_full > $height_full) {
			$width_half		= $width_full / 2;
			$height_half	= $height_full;
			$price_half		= $price_full / 2;
		} else {
			$width_half		= $width_full;
			$height_half	= $height_full /2;
			$price_half		= $price_full / 2;
		}
		
		// Cut the half size in her half to get the quarter size
		// Again, we want to cut the long side not the short side
		if ($width_half > $height_half) {
			$width_quarter		= $width_half / 2;
			$height_quarter		= $height_half;
			$price_quarter		= $price_half / 2;
		} else {
			$width_quarter		= $width_half;
			$height_quarter		= $height_half / 2;
			$price_quarter		= $price_half / 2;
		}
		
		// Now check which size glass peice the customers frame size fits into
		// and use that price
		if ($frame_width <= $width_quarter && $frame_height <= $height_quarter) {
			$glass_price = $price_quarter;
		} else if ($frame_width <= $width_half && $frame_height <= $height_half) {
			$glass_price = $price_half;
		} else if ($frame_width <= $width_full && $frame_height <= $height_full) {
			$glass_price = $price_full;
		}
		
		// Add the percentage wastage
		$glass_price = $glass_price + ($glass_price / 100 * $wastage);
		
		// Add the percentage markup
		$glass_price = $glass_price + ($glass_price / 100 * $markup);
		
		return $glass_price;
	}
}