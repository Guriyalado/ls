<?php

namespace App\Http\Requests\Retailer;

use Illuminate\Foundation\Http\FormRequest;

class CreateRetailerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'retailer_name' =>  ['string', 'required', 'max:255'],
        ];
    }
}
