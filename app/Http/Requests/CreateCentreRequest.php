<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCentreRequest extends Request
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
     * Validation rules used for storing of centre.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|alpha_num_space|unique:centres,name,null,centre_id',
            'postal'        => 'required|digits:6',
            'address'       => 'required|string',
            'address_more'  => 'string',

            // Custom added in 'validate' method
            'address_full'  => 'required|string',
        ];
    }

    /**
     * Validate request
     * @return
     */
    public function validate()
    {
        if (is_string($this->get('address')) && is_string($this->get('address_more'))) {
            if (empty($this->get('address_more')))
                $combinedAddress = $this->get('address');
            else
                $combinedAddress = $this->get('address') . ", " . $this->get('address_more');
            
            $this->merge([
                'address_full' => $combinedAddress,
            ]);
        }

        return parent::validate();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => 'Location name is required.',
            'name.alpha_num_space'  => 'Location name must contain only letters, numbers, or spaces.',
            'name.unique'           => 'Location name is already in the system.',
            'postal.required'       => 'Postal code is required.',
            'postal.digits'         => 'Postal code must be 6 digits.',
            'address.required'      => 'Address is required.',
            'address.string'        => 'Address must be a string.',
            'address_more.string'   => 'Address must be a string.',

            // Custom added in 'validate' method
            'address_full.required' => 'Address is required.',
            'address_full.string'   => 'Address must be a string.',
        ];
    }
}
