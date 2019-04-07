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
		$mount_price = $this->getMountPrice($glass_size_width, $glass_size_height, $mount, $settings);
		
		$total = $mould_price + $glass_price + $mount_price;
		
		return response()->json([
			'mould_price'	=> number_format($mould_price, 2),
			'glass_price'	=> number_format($glass_price / 100, 2),
			'mount_price'	=> number_format($mount_price / 100, 2),
			'total'			=> number_format($total / 100, 2)
		]);
    }
	
	private function getMountPrice($frame_width, $frame_height, $mount, $settings) {
		
		$wastage	= $settings['mount_board_wastage'];
		$markup		= $settings['mount_board_markup'];
		
		$frame = [
			'width'		=> $frame_width,
			'height'	=> $frame_height
		];
		
		$jumbo_peice = [
			'width'		=> $settings['jumbo_mount_board']['width'],
			'height'	=> $settings['jumbo_mount_board']['height'],
			'price'		=> $settings['jumbo_mount_board']['price']
		];
		
		$full_peice = [
			'width'		=> $settings['standard_mount_board']['width'],
			'height'	=> $settings['standard_mount_board']['height'],
			'price'		=> $settings['standard_mount_board']['price']
		];
		
		$half_peice = $this->cutInHalf($full_peice);
		$quarter_peice = $this->cutInHalf($half_peice);
		
		if ($this->fits($frame, $quarter_peice))	{ $mount_price = $quarter_peice['price'];} 
		else if ($this->fits($frame, $half_peice))	{ $mount_price = $half_peice['price'];}
		else if ($this->fits($frame, $full_peice))	{ $mount_price = $full_peice['price'];}
		else if ($this->fits($frame, $jumbo_peice))	{ $mount_price = $jumbo_peice['price'];}
		
		// Add the percentage wastage
		$mount_price = $mount_price + ($mount_price / 100 * $wastage);
		
		// Add the percentage markup
		$mount_price = $mount_price + ($mount_price / 100 * $markup);
		
		return $mount_price;
	}
	
	private function getGlassPrice($frame_width, $frame_height, $settings) {
		
		$wastage	= $settings['glass_wastage'];
		$markup		= $settings['glass_markup'];
		
		$frame = [
			'width'		=> $frame_width,
			'height'	=> $frame_height
		];
		
		// The glass sizes i.e. full, half & quarter		
		$full_peice = [
			'width'		=> $settings['standard_float_glass']['width'],
			'height'	=> $settings['standard_float_glass']['height'],
			'price'		=> $settings['standard_float_glass']['price']
		];
		
		// Cut the full size in her half to get the half size
		$half_peice		= $this->cutInHalf($full_peice);
		
		// Cut the half size in her half to get the quarter size
		$quarter_peice	= $this->cutInHalf($half_peice);
		
		// Now check which size glass peice the customers frame size fits into
		// and use that price
		if ($this->fits($frame, $quarter_peice))	{ $glass_price = $quarter_peice['price'];} 
		else if ($this->fits($frame, $half_peice))	{ $glass_price = $half_peice['price'];}
		else if ($this->fits($frame, $full_peice))	{ $glass_price = $full_peice['price'];}
		
		// Add the percentage wastage
		$glass_price = $glass_price + ($glass_price / 100 * $wastage);
		
		// Add the percentage markup
		$glass_price = $glass_price + ($glass_price / 100 * $markup);
		
		return $glass_price;
	}
	
	private function getMouldPrice($glass_width, $glass_height, $mould_cost, $mould_width, $settings) {
		
		$mould_cut_wastage = $settings['mould_cut_wastage'];
		
		$total_length = $glass_width * 2 + $glass_height * 2 + $mould_width * 8;
		
		$total_mould_cost = ($mould_cost * $total_length) / 1000;
		
		$total_mould_cost_plus_wastage = $total_mould_cost + ($total_mould_cost / 100 * $mould_cut_wastage);
		
		return $total_mould_cost_plus_wastage;
	}
	
	private function fits($frame, $peice) {
		return $frame['width'] <= $peice['width'] && $frame['height'] <= $peice['height'];
	}

	private function cutInHalf($peice) {
		
		// We want to cut the long side not the short side
		if ($peice['width'] > $peice['height']) {
			$width_half		= $peice['width'] / 2;
			$height_half	= $peice['height'];
			$price_half		= $peice['price'] / 2;
		} else {
			$width_half		= $peice['width'];
			$height_half	= $peice['height'] /2;
			$price_half		= $peice['price'] / 2;
		}
		
		return [
			'width' => $width_half,
			'height' => $height_half,
			'price' => $price_half
		];
	}
}