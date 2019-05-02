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
		
		$mounts				= Mount::with('variants')->get();
		$glazings			= Glazing::all();
		$foam_boards		= config('pricing.foam_board');
		$moulds				= config('moulds');
		$job_types			= config('pricing.job_types');
		$fixings			= config('pricing.fixings');
		$artwork_mountings	= config('pricing.artwork_mountings');
		
        return view('admin.orders.create', [
			'mounts'			=> $mounts,
			'glazings'			=> $glazings,
			'foam_boards'		=> json_encode($foam_boards),
			'moulds'			=> json_encode($moulds),
			'job_types'			=> json_encode($job_types),
			'fixings'			=> json_encode($fixings),
			'artwork_mountings'	=> json_encode($artwork_mountings)
		]);
    }

    public function store(Request $request) {
        dd($request);
    }
}