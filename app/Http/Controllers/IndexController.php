<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller {

    public function index(Request $request) {
		
//		$user = $request->user();
//		
//		$userable = $user->userable;
//		
//		dd($userable);
		
        return view('index');
    }
}