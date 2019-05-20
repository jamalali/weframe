<?php

namespace App\Http\Controllers\Mounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mount;
use App\Models\MountVariant;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUpdateMount;
use Illuminate\Support\Arr;

class MountsController extends Controller {
	
    public function index() {
		$mounts = Mount::with('variants')->get();
        
        return view('mounts.index', [
            'mounts' => $mounts
        ]);
    }
	
    public function create() {
        return view('mounts.create');
    }
	
    public function store(StoreUpdateMount $request) {
		
		$input = $request->except(['_token', '_method']);
		
		$variants = Arr::pull($input, 'variants');
        
        $mount = Mount::create($input);
		
		Cache::tags(['mountboard'])->forever($mount->id, $mount);
		
		// Store all the variants if we have any
		if ($variants) {
			foreach ($variants as $variant) {
				$variant['mount_id'] = $mount->id;

				$mountVariant = MountVariant::create($variant);

				// Store in cache
				Cache::tags(['mountboard_variant'])->forever($mountVariant->id, $mountVariant);
			}
		}
        
        return redirect()->route('mounts.index')->with('success', 'New Mount added');
    }
	
    public function show($mount_id) {
		$mount = Mount::with('variants')->where('id', $mount_id)->first();
		
		$CachedMountboard = Cache::tags(['mountboard'])->get($mount_id);
		
		dd($CachedMountboard);
		//return view('mounts.edit', ['mount' => $mount]);
    }
	
    public function edit(Request $request, $mount_id) {
        $mount = Mount::with('variants')->where('id', $mount_id)->first();
		return view('mounts.edit', ['mount' => $mount]);
    }
	
    public function update(StoreUpdateMount $request, Mount $mount) {
		
		$input = $request->except(['_token', '_method']);
        
        $mount->update($input);
		
		Cache::tags(['mountboard'])->forever($mount->id, $mount);
        
        return redirect()->route('mounts.edit', $mount->id)->with('success', 'Mount updated successfully');
    }
	
    public function destroy(Mount $mount) {
		
		// Delete the mount
        $mount->delete();
		
		// Delet its variants
		MountVariant::where('mount_id', $mount->id)->delete();
        
        return redirect()->route('mounts.index')->with('success', 'Mount has been deleted succcesfully');
    }
}