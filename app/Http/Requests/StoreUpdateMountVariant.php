<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateMountVariant extends FormRequest
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
			'sku'		=> 'nullable|alpha_num',
			'colour'	=> 'nullable|alpha',
			'inventory'	=> 'nullable|integer',
			'price'		=> 'nullable|numeric'
        ];
    }
}