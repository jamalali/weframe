<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller {
    
    public function index(Request $request) {
        return view('admin.settings.index');
    }
}
