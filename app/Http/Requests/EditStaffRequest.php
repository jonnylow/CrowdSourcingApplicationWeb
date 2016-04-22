<?php

namespace App\Http\Requests;


/**
 * Form requests class that contains validation logic when editing staff.
 *
 * @package App\Http\Requests
 */
class EditStaffRequest extends Request
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
     * Validation rules used when editing staff.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|alpha_space',
            'email'     => 'required|email|unique:staff,email,' . $this->get('staff_id') . ',staff_id',
            'admin'     => 'boolean',
            'centres'   => 'required|array',
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
            'name.required'     => 'Name is required.',
            'name.alpha_space'  => 'Name must contain only letters or spaces.',
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Email address is invalid.',
            'email.unique'      => 'Email address has been taken.',
            'admin.boolean'     => 'Staff type must be either regular staff or administrator.',
            'centres.required'  => 'Senior centre is required.',
            'centres.array'     => 'Senior centre is required.',
        ];
    }
}
