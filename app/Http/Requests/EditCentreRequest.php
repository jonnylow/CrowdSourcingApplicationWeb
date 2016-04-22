<?php

namespace App\Http\Requests;


/**
 * Form requests class that contains validation logic when editing location/centre.
 *
 * @package App\Http\Requests
 */
class EditCentreRequest extends Request
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
     * Validation rules used when editing location/centre.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|alpha_num_space|unique:centres,name,' . $this->get('centre_id') . ',centre_id',
            'postal'        => 'required|digits:6',
            'address'       => 'required|string',
        ];
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
        ];
    }
}
