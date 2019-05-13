<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Line;

class OrderController extends Controller {
	
	function __construct() {
		
	}
	
    public function store(Request $request) {
		
		$input = $request->all();
		
		$lines = $request->input('lines');
		
		$order = Order::create($input);
		
		$create_lines = [];
		
		foreach($lines as $line) {
			
			$line_total = $line['total'];
			unset($line['total']);
			
			$create_line = [
				'order_id'		=> $order->id,
				'item_params'	=> json_encode($line),
				'qty'			=> 1,
				'total'			=> $line_total
			];
			
			$create_lines[] = $create_line;
		}
		
		$order->lines()->createMany($create_lines);
		
		return response()->json([
			'order_id' => $order->id
		]);
    }
}