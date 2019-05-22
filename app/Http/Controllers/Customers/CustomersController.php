<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mount;
use App\Models\MountVariant;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUpdateCustomer;
use Illuminate\Support\Arr;
use App\Models\Customer;

class CustomersController extends Controller {
	
    public function index() {
		$customers = Customer::get();
        
        return view('customers.index', [
            'customers' => $customers
        ]);
    }
	
    public function create() {
        return view('customers.create');
    }
	
    public function store(StoreUpdateCustomer $request) {
		
		$input = $request->all();
		
		$customer = Customer::create($input);
		$address = $customer->addresses()->create($input['address']);
        
        return redirect()->route('customers.index')->with('success', 'New customer added');
    }
	
    public function show($customer_id) {
		$customer = Customer::find($customer_id);
		return view('customers.show', ['customer' => $customer]);
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