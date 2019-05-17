<?php

namespace App\Http\Controllers\Admin\Mounts\Variants;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mount;
use App\Models\MountVariant;
use App\Http\Requests\StoreUpdateMountVariant;
use Illuminate\Support\Facades\Cache;

class AdminMountsVariantsController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Mount $mount) {
        return view('admin.mounts.variants.create', [
			'mount'		=> $mount,
			'variant'	=> null
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateMountVariant $request, Mount $mount) {
        
		$input = $request->except(['_token', '_method']);
		
		$input['mount_id'] = $mount->id;
		
		$variant = MountVariant::create($input);
		
		Cache::tags(['mountboard_variant'])->forever($variant->id, $variant);
		
		return redirect()->route('admin.mounts.variants.edit', [$mount->id, $variant->id])->with('success', 'Variant added successfully');
    }
	
    public function show($mount_id, $variant) {
		
		$CachedVariant = Cache::tags(['mountboard_variant'])->get($variant->id);
		
		dd($CachedVariant);
    }
	
    public function edit($mount_id, $variant) {
		
		$mount = $variant->mount;
		
		return view('admin.mounts.variants.edit', [
			'mount'		=> $mount,
			'variant'	=> $variant
		]);
    }
	
    public function update(StoreUpdateMountVariant $request, Mount $mount, $variant) {
		
        $input = $request->except(['_token', '_method']);
		
		$variant->update($input);
		
		// Store in cache
		Cache::tags(['mountboard_variant'])->forever($variant->id, $variant);
		
		return redirect()->route('admin.mounts.variants.edit', [$mount->id, $variant->id])->with('success', 'Variant has been updated successfully');
    }
	
    public function destroy($mount_id, $variant) {
		
		// Delete the variant
        $variant->delete();
		
		return redirect()->route('admin.mounts.edit', [$mount_id])->with('success', 'Variant has been deleted succcesfully');
    }
}