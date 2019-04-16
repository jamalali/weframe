<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PriceController extends Controller {
	
	private $include_markup = false;

    public function get(Request $request) {
		
		$settings = Cache::get('settings_pricing');
		
		$mould_cost		= $request->input('mould_cost');
		$mould_width	= $request->input('mould_width');
		
		$mount = json_decode($request->input('mount'));
		
		$glass_size_width		= $request->input('glass_size_width');
		$glass_size_height		= $request->input('glass_size_height');
		
		$glazing_id	= $request->input('glazing');
		
		$dry_mount_included = $request->input('dry_mount_included');
		$fixings_included	= $request->input('fixings_included');
		
		// Get the prices, if we need to
		$mould_price			= $this->getMouldPrice($glass_size_width, $glass_size_height, $mould_cost, $mould_width, $settings);
		$glazing_price			= $this->getGlazingPrice($glass_size_width, $glass_size_height, $glazing_id, $settings);
		$mount_price			= $mount->type != 'none' ? $this->getMountPrice($glass_size_width, $glass_size_height, $mount, $settings) : false;
		$backing_board_price	= $this->getBackingBoardPrice($glass_size_width, $glass_size_height, $settings);
		$dry_mount_price		= filter_var($dry_mount_included, FILTER_VALIDATE_BOOLEAN) ? $this->getDryMountPrice($glass_size_width, $glass_size_height, $dry_mount_included, $settings) : false;
		$fixings_price			= filter_var($fixings_included, FILTER_VALIDATE_BOOLEAN) ? $this->getFixingsPrice($glass_size_width, $glass_size_height, $fixings_included, $settings) : false;
		$other_prices			= $this->getOtherPrices($glass_size_width, $glass_size_height, $settings);
		
		// Build the response array
		$response = [];
		$response['mould'] = $mould_price;
		
		if ($mount_price) { $response['mount'] = $mount_price; }
		
		$response['glazing']			= $glazing_price;
		$response['backing_board']		= $backing_board_price;
		
		if ($dry_mount_price)	{ $response['dry_mount']	= $dry_mount_price; }
		if ($fixings_price)		{ $response['fixings']		= $fixings_price; }
		
		$response['other'] = $other_prices;
		
		$response['markup_included']	= $this->include_markup ? 'Yes' : 'No';
		
		return response()->json($response);
    }
	
	private function getOtherPrices($frame_width, $frame_height, $settings) {
		
		// Calculate the total linear frame length (in metres)
		$total_length = ($frame_width * 2 + $frame_height * 2) / 1000;
		
		$flexi_fletcher_pins	= $settings['flexi_fletcher_pins'];
		$atg_tape				= $settings['atg_tape'];
		$cassese_wedges			= $settings['cassese_wedges'];
		
		// Calculate the cost of flexi/fletcher pins by way of the total linear length of the frame (in pounds)
		$pins_price = ($flexi_fletcher_pins * $total_length) / 100;
		
		// Calculate the cost of ATG tape by way of the total linear length of the frame (in pounds)
		$tape_price = ($atg_tape * $total_length) / 100;
		
		// Cassese wedges price in pounds
		$wedges_price = $cassese_wedges / 100;
		
		return [
			'fletcher_flexi_pins'	=> number_format($pins_price, 2),
			'atg_tape'				=> number_format($tape_price, 2),
			'cassese_wedges'		=> number_format($wedges_price, 2)
		];
	}
	
	private function getFixingsPrice($frame_width, $frame_height, $fixings_included, $settings) {
		
		$d_rings		= $settings['d_rings'];
		$string			= $settings['string'];
		$plastic_bag	= $settings['plastic_bag'];
		
		$d_rings_price		= number_format($d_rings / 100, 2);
		$string_price		= number_format($string / 100, 2);
		$plastic_bag_price	= number_format($plastic_bag / 100, 2);
		
		return [
			'd_rings'		=> $d_rings_price,
			'string'		=> $string_price,
			'plastic_bag'	=> $plastic_bag_price
		];
	}
	
	private function getDryMountPrice($frame_width, $frame_height, $dry_mount_included, $settings) {
		
		if (!filter_var($dry_mount_included, FILTER_VALIDATE_BOOLEAN)) {
			return 'Not included';
		}
		
		$tissue_price = $this->getDryMountTissuePrice($frame_width, $frame_height, $settings);
		$paper_price = $this->getSiliconeReleasePaperPrice($frame_width, $frame_height, $settings);
		$board_price = $this->getPulpBoardPrice($frame_width, $frame_height, $settings);
		
		return [
			'dry_mount_tissue'			=> $tissue_price,
			'silicone_release_paper'	=> $paper_price,
			'pulp_board'				=> $board_price
		];
	}
	
	private function getPulpBoardPrice($frame_width, $frame_height, $settings) {
		
		// NOTE:
		// If the frame is too big for the pulp board we need to use the jumbo mount board
		// so get the jumbo mount board sizes and price
		
		$pulp_board				= $settings['pulp_board'];
		$pulp_board_wastage		= $settings['pulp_board_wastage'];
		$pulp_board_markup		= $settings['pulp_board_markup'];
		
		$mount_board			= $settings['jumbo_mount_board'];
		$mount_board_wastage	= $settings['mount_board_wastage'];
		$mount_board_markup		= $settings['mount_board_markup'];
		
		$frame = [
			'width'		=> $frame_width,
			'height'	=> $frame_height
		];
		
		$mount_board_used = false;
		$mount_board_peice = [
			'width'		=> $mount_board['width'],
			'height'	=> $mount_board['height'],
			'price'		=> $mount_board['price']
		];
		
		// The sheet sizes i.e. full, half & quarter
		$full_peice = [
			'width'		=> $pulp_board['width'],
			'height'	=> $pulp_board['height'],
			'price'		=> $pulp_board['price']
		];
		
		// Cut the full size in her half to get the half size
		$half_peice		= $this->cutInHalf($full_peice);
		
		// Cut the half size in her half to get the quarter size
		$quarter_peice	= $this->cutInHalf($half_peice);
		
		// Now check which size peice the customers frame size fits into
		// and use that price
		if ($this->fits($frame, $quarter_peice))			{ $pulp_board_price = $quarter_peice['price'];} 
		else if ($this->fits($frame, $half_peice))			{ $pulp_board_price = $half_peice['price'];}
		else if ($this->fits($frame, $full_peice))			{ $pulp_board_price = $full_peice['price'];}
		else if ($this->fits($frame, $mount_board_peice))	{ $pulp_board_price = $mount_board_peice['price']; $mount_board_used = true;}
		
		// Add the percentage wastage
		$wastage = $mount_board_used ? $mount_board_wastage : $pulp_board_wastage;
		$pulp_board_price = $pulp_board_price + ($pulp_board_price / 100 * $wastage);
		
		// Add the percentage markup
		if ($this->include_markup) {
			$markup = $mount_board_wastage ? $pulp_board_markup : $mount_board_markup;
			$pulp_board_price = $pulp_board_price + ($pulp_board_price / 100 * $markup);
		}
		
		return number_format($pulp_board_price / 100, 2);
	}
	
	private function getSiliconeReleasePaperPrice($frame_width, $frame_height, $settings) {
		$silicone_release_paper_price	= $settings['silicone_release_paper_price'];
		return number_format($silicone_release_paper_price / 100, 2);
	}
	
	private function getDryMountTissuePrice($frame_width, $frame_height, $settings) {
		
		$tissue_buffer = 10; // There needs to be a little extra tissue around the artwork (in mm)
		
		// Dry mount itssue
		$dry_mount_tissue_width		= $settings['dry_mount_tissue_width'];
		$dry_mount_tissue_price		= $settings['dry_mount_tissue_price']; // price per metre
		$dry_mount_tissue_price_mm	= $dry_mount_tissue_price / 1000; // price per mm
		
		// What length of the roll do we need?
		// Check againt the longest side of the frame size first
		// to see if that fits the width of the dry mount tissue roll
		if ($frame_width > $frame_height && $frame_width <= $dry_mount_tissue_width - $tissue_buffer * 2) {
			$tissue_length_needed = $frame_height + $tissue_buffer * 2;
			
		// If the longest side of the frame is too long rotate it 90 degrees and check againt the short side
		} else if ($frame_height <= $dry_mount_tissue_width - $tissue_buffer * 2) {
			$tissue_length_needed = $frame_width + $tissue_buffer * 2;
		} else {
			$tissue_length_needed = 'The frame is too big for the dry mount tissue paper';
		}
		
		// Now lets work out the cost
		
		if (is_int($tissue_length_needed)) {
			$tissue_price = $dry_mount_tissue_price_mm * $tissue_length_needed;
			$tissue_price = number_format($tissue_price / 100, 2);
		} else {
			$tissue_price = $tissue_length_needed;
		}
		
		return $tissue_price;
	}

	private function getBackingBoardPrice($frame_width, $frame_height, $settings) {
		
		$backing_board = $settings['backing_board'];
		
		$frame = [
			'width'		=> $frame_width,
			'height'	=> $frame_height
		];
		
		// The glass sizes i.e. double, full, half & quarter
		// We don't a seperate jumbo sized backing board so we just double the standard one
		$double_peice	= $this->doubleUp($backing_board);
		
		$full_peice = [
			'width'		=> $backing_board['width'],
			'height'	=> $backing_board['height'],
			'price'		=> $backing_board['price']
		];
		
		// Cut the full size in her half to get the half size
		$half_peice		= $this->cutInHalf($full_peice);
		
		// Cut the half size in her half to get the quarter size
		$quarter_peice	= $this->cutInHalf($half_peice);
		
		// Now check which size peice the customers frame size fits into
		// and use that price
		if ($this->fits($frame, $quarter_peice))		{ $backing_board_price = $quarter_peice['price'];} 
		else if ($this->fits($frame, $half_peice))		{ $backing_board_price = $half_peice['price'];}
		else if ($this->fits($frame, $full_peice))		{ $backing_board_price = $full_peice['price'];}
		else if ($this->fits($frame, $double_peice))	{ $backing_board_price = $double_peice['price'];}
		
		return number_format($backing_board_price / 100, 2);
	}
	
	private function getGlazingPrice($frame_width, $frame_height, $glazing_id, $settings) {
		
		// Get the glazing information from the cache by way of the selected ID
		$glazing = Cache::get('glazing_' . $glazing_id);
		
		$wastage	= $settings['glass_wastage'];
		$markup		= $settings['glass_markup'];
		
		$frame = [
			'width'		=> $frame_width,
			'height'	=> $frame_height
		];
		
		// If standard float glass or mirror glass get the "Oversized" sizes
		$jumbo_peice = false;
		
		if (isset($glazing['oversized_width']) && isset($glazing['oversized_height']) && isset($glazing['oversized_price'])) {
			$jumbo_peice = [
				'width'		=> $glazing['oversized_width'],
				'height'	=> $glazing['oversized_height'],
				'price'		=> $glazing['oversized_price']
			];
		}
		
		// The glass sizes i.e. full, half & quarter
		$full_peice = [
			'width'		=> $glazing['width'],
			'height'	=> $glazing['height'],
			'price'		=> $glazing['price']
		];
		
		// Cut the full size in her half to get the half size
		$half_peice		= $this->cutInHalf($full_peice);
		
		// Cut the half size in her half to get the quarter size
		$quarter_peice	= $this->cutInHalf($half_peice);
		
		// Now check which size glass peice the customers frame size fits into
		// and use that price
		if ($this->fits($frame, $quarter_peice))					{ $glass_price = $quarter_peice['price'];} 
		else if ($this->fits($frame, $half_peice))					{ $glass_price = $half_peice['price'];}
		else if ($this->fits($frame, $full_peice))					{ $glass_price = $full_peice['price'];}
		else if ($jumbo_peice && $this->fits($frame, $jumbo_peice)) { $glass_price = $jumbo_peice['price'];}
		
		// Add the percentage wastage
		$glass_price = $glass_price + ($glass_price / 100 * $wastage);
		
		// Add the percentage markup
		if ($this->include_markup) {
			$glass_price = $glass_price + ($glass_price / 100 * $markup);
		}
		
		return number_format($glass_price / 100, 2);
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
		
		if (!isset($mount_price)) {
			return 'Frame too big for mount';
		}
		
		// Add the percentage wastage
		$mount_price = $mount_price + ($mount_price / 100 * $wastage);
		
		// Add the percentage markup
		if ($this->include_markup) {
			$mount_price = $mount_price + ($mount_price / 100 * $markup);
		}
		
		return number_format($mount_price / 100, 2);
	}
	
	private function getMouldPrice($glass_width, $glass_height, $mould_cost, $mould_width, $settings) {
		
		$mould_cut_wastage = $settings['mould_cut_wastage'];
		
		$total_length = $glass_width * 2 + $glass_height * 2 + $mould_width * 8;
		
		$total_mould_cost = ($mould_cost * $total_length) / 1000;
		
		$total_mould_cost_plus_wastage = $total_mould_cost + ($total_mould_cost / 100 * $mould_cut_wastage);
		
		return number_format($total_mould_cost_plus_wastage, 2);
	}
	
	private function fits($frame, $peice) {
		// we need to check both portrait and landscape orientation
		return $frame['width'] <= $peice['width'] && $frame['height'] <= $peice['height'] || $frame['height'] <= $peice['width'] && $frame['width'] <= $peice['height'];
	}
	
	private function doubleUp($peice) {
		
		if ($peice['width'] > $peice['height']) {
			$width_double	= $peice['width'];
			$height_double	= $peice['height'] * 2;
			$price_double	= $peice['price'] * 2;
		} else {
			$width_double	= $peice['width'] * 2;
			$height_double	= $peice['height'];
			$price_double	= $peice['price'] * 2;
		}
		
		return [
			'width'		=> $width_double,
			'height'	=> $height_double,
			'price'		=> $price_double
		];
	}

	private function cutInHalf($peice) {
		
		// We want to cut the long side not the short side
		if ($peice['width'] > $peice['height']) {
			$width_half		= $peice['width'] / 2;
			$height_half	= $peice['height'];
			$price_half		= $peice['price'] / 2;
		} else {
			$width_half		= $peice['width'];
			$height_half	= $peice['height'] / 2;
			$price_half		= $peice['price'] / 2;
		}
		
		return [
			'width'		=> $width_half,
			'height'	=> $height_half,
			'price'		=> $price_half
		];
	}
}