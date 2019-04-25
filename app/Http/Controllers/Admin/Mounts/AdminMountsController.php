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
        return view('admin.mounts.create');
    }
	
    public function store(StoreUpdateMount $request) {
		
		$input = $request->except(['_token', '_method']);
		
		$variants = Arr::pull($input, 'variants');
        
        $mount = Mount::create($input);
		
		// Store all the variants if we have any
		if ($variants) {
			foreach ($variants as $variant) {
				$variant['mount_id'] = $mount->id;

				$mountVariant = MountVariant::create($variant);

				// Store in cache
				Cache::tags(['mounts'])->forever($mountVariant->id, [
					'mount'		=> $mount,
					'variant'	=> $mountVariant
				]);
			}
		}
        
        return redirect()->route('admin.mounts.index')->with('success', 'New Mount added');
    }
	
    public function show($mount_id) {
		$mount = Mount::with('variants')->where('id', $mount_id)->first();
		dd($mount);
		//return view('admin.mounts.edit', ['mount' => $mount]);
    }
	
    public function edit(Request $request, $mount_id) {
        $mount = Mount::with('variants')->where('id', $mount_id)->first();
		return view('admin.mounts.edit', ['mount' => $mount]);
    }
	
    public function update(StoreUpdateMount $request, Mount $mount) {
		
		$input = $request->except(['_token', '_method']);
        
        $mount->update($input);
        
        return redirect()->route('admin.mounts.edit', $mount->id)->with('success', 'Mount updated successfully');
    }
	
    public function destroy(Mount $mount) {
		
		// Delete the mount
        $mount->delete();
		
		// Delet its variants
		MountVariant::where('mount_id', $mount->id)->delete();
        
        return redirect()->route('admin.mounts.index')->with('success', 'Mount has been deleted succcesfully');
    }
}