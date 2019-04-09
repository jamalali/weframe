<?php

namespace App\Http\Controllers\Admin\Settings\Pricing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class AdminSettingsPricingController extends Controller {
	
	private $settings_namespace = 'pricing';

	public function index(Request $request) {
		
		//$settings = Cache::get('settings_' . $this->settings_namespace);
		
		$settings = Setting::where('namespace', $this->settings_namespace)->get()->pluck('value', 'key');
		
        return view('admin.settings.pricing.index', ['settings' => $settings]);
    }
	
    public function store(Request $request) {
		
		$inputs = $request->except('_token');
		
		foreach ($inputs as $key => $value) {
			
			$value = json_encode($value);
			
			$setting = Setting::where(['key' => $key, 'namespace' => $this->settings_namespace])->first();
			
			if (null == $setting) {
				
				// Add a new record if one does not exist already
				
				$setting = Setting::create([
					'key'		=> $key,
					'value'		=> $value,
					'namespace' => $this->settings_namespace
				]);
				
			} else {
				
				// Update the exiting record with the new value
				
				$setting = Setting::where('key', $key)
					->where('namespace', $this->settings_namespace)
					->update([
						'value' => $value
					]);
				}
			
			// The reason for doing this like this and using Eloquent's updateOrCreate method or DB updateOrInsert
			// is because the Setting model has a composite key, which Eloquent doesn't support properly
			// and because if using the DB updateOrInsert timestamps are not added
			// so timestamps need to be manually added (and handled properly later if updating)
		}
		
		Cache::forever('settings_' . $this->settings_namespace, $inputs);
		
		return redirect()->route('admin.settings.pricing.index')->with('success', 'Settings saved');
    }
}