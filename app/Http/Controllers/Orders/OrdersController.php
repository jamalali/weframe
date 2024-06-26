<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mount;
use App\Models\Order;
use App\Models\Customer;

class OrdersController extends Controller {

    public function index() {
        $orders = Order::orderBy('id', 'desc')->get();
        
        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    public function create(Request $request) {
		
		$customer_id = $request->input('customer_id') ? $request->input('customer_id') : false;
		
		$customer = $customer_id ? Customer::find($customer_id) : false;
		
		$mounts				= Mount::with('variants')->get();
		$glazings			= config('glazings');
		$foam_boards		= config('pricing.foam_board');
		$moulds				= config('moulds');
		$order_types		= config('pricing.order_types');
		$fixings			= config('pricing.fixings');
		$artwork_mountings	= config('pricing.artwork_mountings');
		
		//dd($glazing);
		
		//$moulds = Arr::only($moulds, 'name');
		
		//dd($moulds);
		
        return view('orders.create', [
			'mounts'			=> $mounts,
			'glazings'			=> json_encode($glazings),
			'foam_boards'		=> json_encode($foam_boards),
			'moulds'			=> json_encode($moulds),
			'order_types'		=> json_encode($order_types),
			'fixings'			=> json_encode($fixings),
			'artwork_mountings'	=> json_encode($artwork_mountings),
			'customer'			=> $customer
		]);
    }

	public function show(Order $order) {
		return view('orders.show', [
            'order' => $order
        ]);
    }
}