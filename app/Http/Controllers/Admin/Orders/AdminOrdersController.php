<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Glazing;

class AdminOrdersController extends Controller {

    public function index() {
        return view('admin.orders.index');
    }

    public function create() {
		
		$glazings = Glazing::all();
		
		//dd($glazings);
		
        return view('admin.orders.create', [
			'glazings' => $glazings
		]);
    }

    public function store(Request $request) {
        dd($request);
    }
}