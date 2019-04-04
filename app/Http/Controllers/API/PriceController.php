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
		
		$mould_cost				= $request->input('mould_cost');
		$mould_width			= $request->input('mould_width');
		$glass_size_width		= $request->input('glass_size_width');
		$glass_size_height		= $request->input('glass_size_height');
		
		$total_length = $glass_size_width * 2 + $glass_size_height * 2 + $mould_width * 8;
		
		$total_mould_cost = ($mould_cost * $total_length) / 1000;
		
		$total_mould_cost_plus_wastage = $total_mould_cost + ($total_mould_cost / 100 * 20);
		
		return response()->json([
			'total_length' => $total_length,
			'total_mould_cost' => $total_mould_cost,
			'total_mould_cost_plus_wastage' => $total_mould_cost_plus_wastage
		]);
    }
}