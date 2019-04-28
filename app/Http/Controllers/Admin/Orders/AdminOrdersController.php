<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Glazing;
use App\Models\Mount;

class AdminOrdersController extends Controller {

    public function index() {
        return view('admin.orders.index');
    }

    public function create() {
		
		$mounts			= Mount::with('variants')->get();
		$glazings		= Glazing::all();
		$foam_boards	= (object) config('pricing.foam_board');
		

		

		
		
		
        return view('admin.orders.create', [
			'mounts'		=> $mounts,
			'glazings'		=> $glazings,
			'foam_boards'	=> json_encode($foam_boards)
		]);
    }

    public function store(Request $request) {
        dd($request);
    }
}