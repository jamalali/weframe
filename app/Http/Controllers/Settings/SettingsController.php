<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller {
    
    public function index(Request $request) {
        return view('settings.index');
    }
}
