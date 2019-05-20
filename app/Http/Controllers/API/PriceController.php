<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PriceController extends Controller {
	
	private $include_markup = false;
	
	private $labour_costs	= [];
	
	private $labour_config	= [];
	private $wastage_config	= [];
	
	private $settings = null;
	
	private $order_type = 0;
	
	private $glass_width	= 0;
	private $glass_height	= 0;
	
	function __construct() {
		$this->labour_config	= config('pricing.labour');
		$this->wastage_config	= config('pricing.wastage');
	}

    public function get(Request $request) {
		
		$this->setGlassDimensions($request);
		
		$this->settings = Cache::get('settings_pricing');
		
		$this->order_type = $request->input('orderType');
		
		$moulding_id = $request->input('moulding');
		
		$mount = json_decode($request->input('mount'));
		
		$glazing_id				= $request->input('glazing');
		$foam_board_id			= $request->input('foamBoard');
		$fixing_id				= $request->input('fixing');
		$artwork_mounting_id	= $request->input('artworkMounting');
		
		// Get the prices, if we need to
		$moulding_price				= $this->getMouldingPrice($moulding_id);
		$glazing_price				= !empty($glazing_id) ? $this->getGlazingPrice($glazing_id) : false;
		$foam_board_price			= !empty($foam_board_id) ? $this->getFoamBoardPrice($foam_board_id) : false;
		$fixing_price				= !empty($fixing_id) ? $this->getFixingPrice($fixing_id) : false;
		$artwork_mounting_price		= !empty($artwork_mounting_id) ? $this->getArtworkMountingPrice($artwork_mounting_id) : false;
		$mount_price				= $mount->type != 'none' ? $this->getMountPrice($mount) : false;
		$backing_board_price		= $this->getBackingBoardPrice();
		$other_prices				= $this->getOtherPrices();
		
		$this->setLabourCosts($request);
		
		// Build the response array
		$response = [];
		$response['moulding'] = $moulding_price;
		
		if ($mount_price)	{ $response['mount'] = $mount_price; }
		if ($glazing_price) { $response['glazing'] = $glazing_price; }
		
		$response['backing_board']		= $backing_board_price;
		
		if ($foam_board_price)			{ $response['foam_board']			= $foam_board_price; }
		if ($fixing_price)				{ $response['fixing']				= $fixing_price; }
		if ($artwork_mounting_price)	{ $response['artwork_mounting']		= $artwork_mounting_price; }
		
		$response['other'] = $other_prices;
		
		$response['labour'] = $this->labour_costs;
		
		$response['markup_included']	= $this->include_markup ? 'Yes' : 'No';
		
		return response()->json($response);
    }
	
	private function setGlassDimensions($request) {
		
		$mount			= json_decode($request->input('mount'));
		$mount_type		= $mount->type;
		
		//die(print_r($mount));
		
		$artwork_width	= $request->input('artworkWidth');
		$artwork_height = $request->input('artworkHeight');
		
		$this->glass_width		= $artwork_width;
		$this->glass_height		= $artwork_height;
		
		// If a mount or double mount has been selected we need to add the mount border sizes to the artwork size to get the glass size
		
		switch ($mount_type) {
			case 'single':
			case 'circular':
			case 'oval':
				$top_mount = $mount->top;
				
				$glass_width = $artwork_width;
				$glass_height = $artwork_height;
				
				if (is_numeric($top_mount->sizes->left))	{ $glass_width = $glass_width + $top_mount->sizes->left; }
				if (is_numeric($top_mount->sizes->right))	{ $glass_width = $glass_width + $top_mount->sizes->right; }
				
				if (is_numeric($top_mount->sizes->top))		{ $glass_height	= $glass_height + $top_mount->sizes->top; }
				if (is_numeric($top_mount->sizes->bottom))	{ $glass_height	= $glass_height + $top_mount->sizes->bottom; }
				
				$this->glass_width	= $glass_width;
				$this->glass_height = $glass_height;
				
				break;
			
			case 'double':
				$top_mount		= $mount->top;
				$bottom_mount	= $mount->bottom;
				
				$this->glass_width	= $artwork_width + $top_mount->sizes->left + $top_mount->sizes->right + $bottom_mount->size * 2;
				$this->glass_height = $artwork_height + $top_mount->sizes->top + $top_mount->sizes->bottom + $bottom_mount->size * 2;
				
				break;
			
			case 'multimount':
				
				break;
				
		}
	}
	
	private function getFoamBoardPrice($foam_board_id) {
		
		$foam_board	= config('pricing.foam_board.' . $foam_board_id);
		
		// The glass sizes i.e. full, half & quarter
		$full_peice = [
			'width'		=> $foam_board['width'],
			'height'	=> $foam_board['height'],
			'price'		=> $foam_board['price']
		];
		
		if ($this->fits($full_peice)) {
			$foam_board_price = $this->getSqMetrePrice($full_peice);
		} else {
			return 'Frame too big for glazing';
		}
		
		return number_format($foam_board_price / 100, 2);
	}
	
	private function setLabourCosts($request) {
		
		switch ($this->order_type) {
			case '1': // Walk-in
				$this->labour_costs['sealing'] = $this->labourCostInPounds($this->labour_config['sealing']);
				break;
		}
		
		$artwork_supplied	= $request->input('artworkSupplied');
		$box_frame			= $request->input('boxFrame');
		
		if (filter_var($artwork_supplied, FILTER_VALIDATE_BOOLEAN)) {
			$this->labour_costs['mount_supplied_artwork'] = $this->labourCostInPounds($this->labour_config['atg_tape_mounting']);
		}
		
		if (filter_var($box_frame, FILTER_VALIDATE_BOOLEAN)) {
			$this->labour_costs['lining_frame'] = $this->labourCostInPounds($this->labour_config['lining_frame']);
		}
		
		$this->labour_costs['assembly'] = $this->labourCostInPounds($this->labour_config['assembly']);
	}
	
	private function getOtherPrices() {
		
		// Calculate the total linear frame length (in metres)
		$total_length = ($this->glass_width * 2 + $this->glass_height * 2) / 1000;
		
		$flexi_fletcher_pins	= $this->settings['flexi_fletcher_pins'];
		$atg_tape				= $this->settings['atg_tape'];
		$cassese_wedges			= $this->settings['cassese_wedges'];
		
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
	
	private function getArtworkMountingPrice($artwork_mounting_id) {
		
		switch ($artwork_mounting_id) {
			case 'dry_mount':
				$tissue_price = $this->getDryMountTissuePrice();
				$paper_price = $this->getSiliconeReleasePaperPrice();
				$board_price = $this->getPulpBoardPrice();

				$this->labour_costs['dry_mount'] = $this->labourCostInPounds($this->labour_config['dry_mount']);

				return [
					'dry_mount_tissue'			=> $tissue_price,
					'silicone_release_paper'	=> $paper_price,
					'pulp_board'				=> $board_price
				];
			
			case 'hinge_mount':
				$this->labour_costs['hinge_mount'] = $this->labourCostInPounds($this->labour_config['hinge_mount']);
				// TODO: need to add cost of ATG tape here
				break;
			
			case 'photo_mount':
				$this->labour_costs['attach_picture_stand'] = $this->labourCostInPounds($this->labour_config['attach_picture_stand']);
				break;
		}
	}
	
	private function getFixingPrice($fixing_id) {
		
		switch ($fixing_id) {
			case 'standard_string':
				$d_rings		= $this->settings['d_rings'];
				$string			= $this->settings['string'];
				$plastic_bag	= $this->settings['plastic_bag'];

				$d_rings_price		= number_format($d_rings / 100, 2);
				$string_price		= number_format($string / 100, 2);
				$plastic_bag_price	= number_format($plastic_bag / 100, 2);

				return [
					'd_rings'		=> $d_rings_price,
					'string'		=> $string_price,
					'plastic_bag'	=> $plastic_bag_price
				];
				
			case 'invisible':
				// TODO: need price for this
				break;
			
			case 'picture_stand':
				return [
					'attach_picture_stand' => $this->labourCostInPounds($this->labour_config['attach_picture_stand'])
				];
		}
	}
	
	private function getPulpBoardPrice() {
		
		// NOTE:
		// If the frame is too big for the pulp board we need to use the jumbo mount board
		// so get the jumbo mount board size and price
		// we will use the standard whitecore jumbo one
		
		$pulp_board				= $this->settings['pulp_board'];
		$pulp_board_wastage		= $this->settings['pulp_board_wastage'];
		$pulp_board_markup		= $this->settings['pulp_board_markup'];
		
		$mount_board			= Cache::tags(['mountboard'])->get(3);
		
		$mount_board_wastage	= $this->settings['mount_board_wastage'];
		$mount_board_markup		= $this->settings['mount_board_markup'];
		
		$mount_board_used = false;
		$mount_board_peice = [
			'width'		=> $mount_board->oversized_width,
			'height'	=> $mount_board->oversized_height,
			'price'		=> $mount_board->oversized_price
		];
		
		// The sheet sizes i.e. full, half & quarter
		$full_peice = [
			'width'		=> $pulp_board['width'],
			'height'	=> $pulp_board['height'],
			'price'		=> $pulp_board['price']
		];
		
		if ($this->fits($full_peice))				{ $size_to_use = 'full';}
		else if ($this->fits($mount_board_peice))	{ $size_to_use = 'jumbo'; $mount_board_used = true;}
		
		switch ($size_to_use) {
			case 'full':
				$pulp_board_price = $this->getSqMetrePrice($full_peice);
				break;
			case 'jumbo':
				$pulp_board_price = $this->getSqMetrePrice($mount_board_peice);
				break;
		}
		
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
	
	private function getSiliconeReleasePaperPrice() {
		$silicone_release_paper_price	= $this->settings['silicone_release_paper_price'];
		return number_format($silicone_release_paper_price / 100, 2);
	}
	
	private function getDryMountTissuePrice() {
		
		$tissue_buffer = 10; // There needs to be a little extra tissue around the artwork (in mm)
		
		// Dry mount itssue
		$dry_mount_tissue_width		= $this->settings['dry_mount_tissue_width'];
		$dry_mount_tissue_price		= $this->settings['dry_mount_tissue_price']; // price per metre
		$dry_mount_tissue_price_mm	= $dry_mount_tissue_price / 1000; // price per mm
		
		// What length of the roll do we need?
		// Check againt the longest side of the frame size first
		// to see if that fits the width of the dry mount tissue roll
		if ($this->glass_width > $this->glass_height && $this->glass_width <= $dry_mount_tissue_width - $tissue_buffer * 2) {
			$tissue_length_needed = $this->glass_height + $tissue_buffer * 2;
			
		// If the longest side of the frame is too long rotate it 90 degrees and check againt the short side
		} else if ($this->glass_height <= $dry_mount_tissue_width - $tissue_buffer * 2) {
			$tissue_length_needed = $this->glass_width + $tissue_buffer * 2;
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

	private function getBackingBoardPrice() {
		
		$backing_board = $this->settings['backing_board'];
		
		$full_peice = [
			'width'		=> $backing_board['width'],
			'height'	=> $backing_board['height'],
			'price'		=> $backing_board['price']
		];
		
		if ($this->fits($full_peice)) {
			$backing_board_price = $this->getSqMetrePrice($full_peice);
		} else {
			return 'Frame too big for backing board';
		}
		
		// Labour costs
		$this->labour_costs['cutting_backing_board'] = $this->labourCostInPounds($this->labour_config['cutting_backing_board']);
		
		return number_format($backing_board_price / 100, 2);
	}
	
	private function getGlazingPrice($glazing_id) {
		
		$glass_price = 0;
		
		// Get the glazing information from the config file by way of the selected (2-part in some cases) ID
		$glazing_id_parts = explode('-', $glazing_id);
		
		$glazing_category	= $glazing_id_parts[0];
		
		$glazing = config('glazings.' . $glazing_category);
		
		if (isset($glazing['options'])) {
			
			// If glazing catgory has options the option should have been selected
			
			if (isset($glazing_id_parts[1])) {
				$glazing_option = $glazing_id_parts[1];
			} else {
				return 'Glazing option not seleted';
			}
			
			$glazing = $glazing['options'][$glazing_option];
		}
		
		$wastage	= $this->settings['glass_wastage'];
		$markup		= $this->settings['glass_markup'];
		
		// Get the "Oversized" sizes
		$jumbo_peice = false;
		
		if (isset($glazing['sheet']['oversized'])) {
			$jumbo_peice = [
				'width'		=> $glazing['sheet']['oversized']['width'],
				'height'	=> $glazing['sheet']['oversized']['height'],
				'price'		=> $glazing['sheet']['oversized']['price']
			];
		}
		
		$full_peice = [
			'width'		=> $glazing['sheet']['width'],
			'height'	=> $glazing['sheet']['height'],
			'price'		=> $glazing['sheet']['price']
		];
		
		// Now check which size glass peice the customers frame size fits into
		if ($this->fits($full_peice))						{ $size_to_use = 'full';}
		else if ($jumbo_peice && $this->fits($jumbo_peice)) { $size_to_use = 'jumbo';}
		
		if (!isset($size_to_use)) {
			return 'Frame too big for glazing';
		}
		
		switch ($size_to_use) {
			case 'full':
				$glass_price = $this->getSqMetrePrice($full_peice);
				break;
			case 'jumbo':
				$glass_price = $this->getSqMetrePrice($jumbo_peice);
				break;
		}
		
		// Add the percentage wastage
		$glass_price = $glass_price + ($glass_price / 100 * $wastage);
		
		// Add the percentage markup
		if ($this->include_markup) {
			$glass_price = $glass_price + ($glass_price / 100 * $markup);
		}
		
		return number_format($glass_price / 100, 2);
	}
	
	private function getSqMetrePrice($sheet) {
		
		// calculate the cost of this sheet for 1 square metre
		$sheet_square_metre_cost = $sheet['price'] / ($sheet['width'] / 1000 * $sheet['height'] / 1000); // we divide by 1000 because width & height are millimetres
		
		// calculate the glass size in square metres
		$glass_square_metres = $this->glass_width / 1000 * $this->glass_height / 1000;
		
		// calculate the cost by way of the glass size and the cost per 1 metre
		$price = $sheet_square_metre_cost * $glass_square_metres;
		
		return $price;
	}
	
	private function getMountPrice($mount) {
		
		$mount_type	= $mount->type;
		
		switch ($mount_type) {
			case 'single':
			case 'circular':
			case 'oval':
				$top_mount = $mount->top;
				$top_mount_cost = $this->getCostOfMountboard($top_mount->colour);
				
				// Labour costs
				$this->labour_costs['cutting_mountboard'] = $this->labourCostInPounds($this->labour_config['cutting_mountboard']);
				
				return $top_mount_cost;
			
			case 'double':
				$top_mount		= $mount->top;
				$bottom_mount	= $mount->bottom;
				
				$top_mount_cost		= $this->getCostOfMountboard($top_mount->colour);
				$bottom_mount_cost	= $this->getCostOfMountboard($bottom_mount->colour);
				
				// Labour costs
				$this->labour_costs['cutting_mountboard'] = $this->labourCostInPounds($this->labour_config['cutting_mountboard'] * 2);
				
				return [
					'top_mount'		=> $top_mount_cost,
					'bottom_mount'	=> $bottom_mount_cost
				];
			
			case 'multimount':
				$num_apertures	= $mount->num_apertures;
				$mount_colour	= $mount->colour;
				
				$mount_cost = $this->getCostOfMountboard($mount_colour);
				
				// Labour costs
				$this->labour_costs['cutting_mountboard'] = $this->labourCostInPounds($this->labour_config['multimount'] * $num_apertures);
				
				return $mount_cost;
		}
	}
	
	private function getCostOfMountboard($mount_colour) {
		
		$wastage	= $this->settings['mount_board_wastage'];
		$markup		= $this->settings['mount_board_markup'];
		
		$mount_variant	= Cache::tags(['mountboard_variant'])->get($mount_colour);
		$mount			= Cache::tags(['mountboard'])->get($mount_variant->mount_id);
		
		$jumbo_peice = false;
		
		if (isset($mount['oversized_width']) && isset($mount['oversized_height']) && isset($mount['oversized_price'])) {
			$jumbo_peice = [
				'width'		=> $mount['oversized_width'],
				'height'	=> $mount['oversized_height'],
				'price'		=> $mount_variant['oversized_price'] ? $mount_variant['oversized_price'] : $mount['oversized_price']
				// if the variant has a price this will override its parent mounr price
			];
		}
		
		$full_peice = [
			'width'		=> $mount['width'],
			'height'	=> $mount['height'],
			'price'		=> $mount_variant['price'] ? $mount_variant['price'] : $mount['price'],
			// if the variant has a price this will override its parent mounr price
		];
		
		if ($this->fits($full_peice))						{ $size_to_use = 'full';}
		else if ($jumbo_peice && $this->fits($jumbo_peice))	{ $size_to_use = 'jumbo';}
		
		if (!isset($size_to_use)) {
			return 'Frame too big for mount';
		}
		
		switch ($size_to_use) {
			case 'full':
				$mount_price = $this->getSqMetrePrice($full_peice);
				break;
			case 'jumbo':
				$mount_price = $this->getSqMetrePrice($jumbo_peice);
				break;
		}
		
		// Add the percentage wastage
		$mount_price = $mount_price + ($mount_price / 100 * $wastage);
		
		// Add the percentage markup
		if ($this->include_markup) {
			$mount_price = $mount_price + ($mount_price / 100 * $markup);
		}
		
		return number_format($mount_price / 100, 2);
	}
	
	private function getMouldingPrice($moulding_id) {
		
		$moulding	= config('moulds.' . $moulding_id);
		
		$moulding_width = $moulding['width'];
		$moulding_price = $moulding['price'];
		
		$moulding_cut_wastage = $this->wastage_config['mould'];
		
		$total_length = $this->glass_width * 2 + $this->glass_height * 2 + $moulding_width * 8;
		
		$total_moulding_cost = ($moulding_price * $total_length) / 1000;
		
		$total_moulding_cost_plus_wastage = $total_moulding_cost + ($total_moulding_cost / 100 * $moulding_cut_wastage);
		
		// Labour costs
		$this->labour_costs['cutting_frame'] = $this->labourCostInPounds($this->labour_config['cutting_frame']);
		
		if ($this->glass_width >= $this->labour_config['big_frame']['width'] && $this->glass_height >= $this->labour_config['big_frame']['height']) {
			$this->labour_costs['pinning_frame'] = $this->labourCostInPounds($this->labour_config['pinning_big_frame']);
		} else {
			$this->labour_costs['pinning_frame'] = $this->labourCostInPounds($this->labour_config['pinning_frame']);
		}
		
		return number_format($total_moulding_cost_plus_wastage, 2);
	}
	
	private function labourCostInPounds($minutes) {
		$cost = ($minutes * $this->labour_config['pence_per_minute']) / 100;
		return number_format($cost, 2);
	}
	
	private function fits($peice) {
		// we need to check both portrait and landscape orientation
		return $this->glass_width <= $peice['width'] && $this->glass_height <= $peice['height'] || $this->glass_height <= $peice['width'] && $this->glass_width <= $peice['height'];
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