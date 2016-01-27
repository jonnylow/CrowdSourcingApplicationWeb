<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

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
     * Validation rules used for storing of staff.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|name',
            'email'     => 'required|email|unique:staff,email,' . $this->get('staff_id') . ',staff_id',
            'admin'     => 'required|boolean',
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
            'name.name'         => 'Name must contain only alphabets, commas, hyphens, or slashes.',
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Email address is invalid.',
            'email.unique'      => 'Email address has been taken.',
            'admin.required'    => 'Staff type is required.',
            'admin.boolean'     => 'Staff type must be either regular or admin.',
            'centres.required'  => 'Centre is required.',
            'centres.array'     => 'Centre is required.',
        ];
    }
}
