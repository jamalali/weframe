<?php

namespace App\Http\Controllers\Admin\Orders\Lines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Glazing;
use App\Models\Mount;
use App\Models\Order;

class AdminOrdersLinesController extends Controller {

    public function index() {
        $orders = Order::orderBy('id', 'desc')->get();
        
        return view('admin.orders.index', [
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
		
        return view('admin.orders.create', [
			'mounts'			=> $mounts,
			'glazings'			=> $glazings,
			'foam_boards'		=> json_encode($foam_boards),
			'moulds'			=> json_encode($moulds),
			'order_types'			=> json_encode($order_types),
			'fixings'			=> json_encode($fixings),
			'artwork_mountings'	=> json_encode($artwork_mountings)
		]);
    }

	public function show(Order $order) {
		return view('admin.orders.show', [
            'order' => $order
        ]);
    }
}