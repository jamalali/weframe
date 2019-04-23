<?php

namespace App\Http\Controllers\Admin\Mounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mount;
use App\Models\MountVariant;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUpdateMount;
use Illuminate\Support\Arr;

class AdminMountsController extends Controller {
	
    public function index() {
		$mounts = Mount::with('variants')->get();
        
        return view('admin.mounts.index', [
            'mounts' => $mounts
        ]);
    }
	
    public function create() {
        return view('admin.mounts.create', [
			'glazing' => null
		]);
    }
	
    public function store(StoreUpdateMount $request) {
		
		$input = $request->except(['_token', '_method']);
		
		$variants = Arr::pull($input, 'variants');
        
        $mount = Mount::create($input);
		
		foreach ($variants as $variant) {
			$variant['mount_id'] = $mount->id;
			
			$mountVariant = MountVariant::create($variant);
			
			// Store in cache
			Cache::tags(['mounts'])->forever($mountVariant->id, [
				'mount'		=> $mount,
				'variant'	=> $mountVariant
			]);
		}
        
        return redirect()->route('admin.mounts.index')->with('success', 'New Mount added');
    }
	
    public function show(Mount $mount) {
		
		$mount_cache = Cache::get('mount_' . $mount->id);
		
        dd($mount);
    }
	
    public function edit(Request $request, Glazing $glazing) {
        return view('admin.mounts.edit', ['glazing' => $glazing]);
    }
	
    public function update(StoreUpdateGlazing $request, Glazing $glazing) {
		
		$input = $request->except(['_token', '_method']);
		
		$input['exclude_online'] = isset($input['exclude_online']) ? 1 : 0;
        
        $glazing->update($input);
		
		$this->_cache($glazing->id, $input);
        
        return redirect()->route('admin.mounts.index')->with('success', 'Glazing updated');
    }
	
    public function destroy(Glazing $glazing) {
		
        $glazing->delete();
        
        return redirect()->route('admin.mounts.index')->with('success', 'Group deleted');
    }
	
	private function _cache($id, $data) {
		Cache::forever('mount_' . $id, $data);
	}
}