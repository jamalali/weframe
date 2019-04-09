<?php

namespace App\Http\Controllers\Admin\Settings\Glazing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GlazingOption;

class AdminSettingsGlazingController extends Controller {
	
    public function index() {
		$glazing_options = GlazingOption::all();
        
        return view('admin.settings.glazing.index', [
            'glazing_options' => $glazing_options
        ]);
    }
	
    public function create() {
        return view('admin.settings.glazing.create');
    }
	
    public function store(Request $request) {
		
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
		
		$input = $request->all();
        
        $glazing_option = GlazingOption::create($input);
        
        return redirect()->route('admin.settings.glazing.index')->with('success', 'New Glazing option added');
    }
	
    public function show($id) {
        //
    }
	
    public function edit($id) {
        //
    }
	
    public function update(Request $request, $id) {
        //
    }
	
    public function destroy($id)
    {
        //
    }
}