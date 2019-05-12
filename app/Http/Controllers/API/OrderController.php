<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller {
	
	function __construct() {
		
	}
	
    public function store(Request $request) {
		
		$order_type = $request->input('order_type');
		$lines = $request->input('lines');
		
		print_r($order_type);
		die();
    }
}