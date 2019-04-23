<?php

namespace App\Http\Controllers\Admin\Mounts\Variants;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mount;
use App\Http\Requests\StoreUpdateMountVariant;
use Illuminate\Support\Facades\Cache;

class AdminMountsVariantsController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
	
    public function show($mount, $variant) {
		dd($variant);
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
		Cache::tags(['mounts'])->forever($variant->id, [
			'mount'		=> $mount,
			'variant'	=> $variant
		]);
		
		return redirect()->route('admin.mounts.variants.edit', [$mount->id, $variant->id])->with('success', 'Variant has been updated successfully');
    }
	
    public function destroy($mount_id, $variant) {
		
		// Delete the variant
        $variant->delete();
		
		return redirect()->route('admin.mounts.edit', [$mount_id])->with('success', 'Variant has been deleted succcesfully');
    }
}
