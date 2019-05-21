<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
		
        return [
            'first_name'	=> 'required|string|max:255',
            'last_name'		=> 'required|string|max:255',
            'email'			=> 'nullable|email',
            'phone_number'	=> 'nullable|digits:11',
			
			'address.first_name'	=> 'nullable|string|max:255',
            'address.last_name'		=> 'nullable|string|max:255',
            'address.company'		=> 'nullable|string|max:255',
            'address.address_1'		=> 'required|string|max:255',
            'address.address_2'		=> 'nullable|string|max:255',
            'address.town'			=> 'required|string|max:255',
            'address.county'		=> 'nullable|string|max:255',
			'address.postcode'		=> 'required|string|max:255',
            'address.phone_number'	=> 'nullable|digits:11',
        ];
    }
}