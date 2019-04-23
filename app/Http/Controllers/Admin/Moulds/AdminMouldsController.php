<?php

namespace App\Http\Controllers\Admin\Moulds;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Glazing;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUpdateGlazing;

class AdminMouldsController extends Controller {
	
    public function index() {
		$glazing_options = Glazing::all();
        
        return view('admin.moulds.index', [
            'glazing_options' => $glazing_options
        ]);
    }
	
    public function create() {
        return view('admin.moulds.create', [
			'glazing' => null
		]);
    }
	
    public function store(StoreUpdateGlazing $request) {
		
		$input = $request->except(['_token', '_method']);
		
		$input['exclude_online'] = isset($input['exclude_online']) ? 1 : 0;
        
        $glazing = Glazing::create($input);
		
		Cache::forever('glazing_' . $glazing->id, $input);
        
        return redirect()->route('admin.moulds.index')->with('success', 'New Glazing option added');
    }
	
    public function show(Glazing $glazing) {
		
		$glazing_cache = Cache::get('glazing_' . $glazing->id);
		
        dd($glazing_cache);
    }
	
    public function edit(Request $request, Glazing $glazing) {
        return view('admin.moulds.edit', ['glazing' => $glazing]);
    }
	
    public function update(StoreUpdateGlazing $request, Glazing $glazing) {
		
		$input = $request->except(['_token', '_method']);
		
		$input['exclude_online'] = isset($input['exclude_online']) ? 1 : 0;
        
        $glazing->update($input);
		
		Cache::forever('glazing_' . $glazing->id, $input);
        
        return redirect()->route('admin.moulds.index')->with('success', 'Glazing updated');
    }
	
    public function destroy(Glazing $glazing) {
		
        $glazing->delete();
        
        return redirect()->route('admin.moulds.index')->with('success', 'Group deleted');
    }
}