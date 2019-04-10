<?php

namespace App\Http\Controllers\Admin\Settings\Glazings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Glazing;
use Illuminate\Support\Facades\Cache;

class AdminSettingsGlazingsController extends Controller {
	
    public function index() {
		$glazing_options = Glazing::all();
        
        return view('admin.settings.glazings.index', [
            'glazing_options' => $glazing_options
        ]);
    }
	
    public function create() {
        return view('admin.settings.glazings.create', [
			'glazing' => null
		]);
    }
	
    public function store(Request $request) {
		
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'price' => 'required|numeric',
			'exclude_online' => 'boolean'
        ]);
		
		$input = $request->except(['_token', '_method']);
		
		$input['exclude_online'] = isset($input['exclude_online']) ? 1 : 0;
        
        $glazing = Glazing::create($input);
		
		Cache::forever('glazing_' . $glazing->id, $input);
        
        return redirect()->route('admin.settings.glazings.index')->with('success', 'New Glazing option added');
    }
	
    public function show(Glazing $glazing) {
		
		$glazing_cache = Cache::get('glazing_' . $glazing->id);
		
        dd($glazing_cache);
    }
	
    public function edit(Request $request, Glazing $glazing) {
        return view('admin.settings.glazings.edit', ['glazing' => $glazing]);
    }
	
    public function update(Request $request, Glazing $glazing) {
        
		$validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'price' => 'required|numeric',
			'exclude_online' => 'boolean'
        ]);
		
		$input = $request->except(['_token', '_method']);
		
		$input['exclude_online'] = isset($input['exclude_online']) ? 1 : 0;
        
        $glazing->update($input);
		
		Cache::forever('glazing_' . $glazing->id, $input);
        
        return redirect()->route('admin.settings.glazings.index')->with('success', 'Glazing updated');
    }
	
    public function destroy(Glazing $glazing) {
		
        $glazing->delete();
        
        return redirect()->route('admin.settings.glazings.index')->with('success', 'Group deleted');
    }
}