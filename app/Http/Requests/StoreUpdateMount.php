<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateMount extends FormRequest
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
            'name'		=> 'required|string|max:255',
            'width'		=> 'required|numeric',
            'height'	=> 'required|numeric',
            'price'		=> 'required|numeric',
			
            'oversized_width'	=> 'nullable|numeric',
            'oversized_height'	=> 'nullable|numeric',
            'oversized_price'	=> 'nullable|numeric',
			
			'variants.*.sku'		=> 'nullable|alpha_num',
			'variants.*.colour'		=> 'nullable|alpha',
			'variants.*.inventory'	=> 'nullable|integer',
			'variants.*.price'		=> 'nullable|numeric'
        ];
    }
}