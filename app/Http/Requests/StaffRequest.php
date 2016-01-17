<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StaffRequest extends Request
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
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            // Update operation, exclude the record with id from the validation:
            $email_rule = 'required|email|unique:staff,email,' . $this->get('staff_id') . ',staff_id';
        } else {
            // Create operation. There is no id yet.
            $email_rule = 'required|email|unique:staff,email,null,staff_id';
        }

        return [
            'name'      => 'required|string',
            'email'     => $email_rule,
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
            'name.string'       => 'Name must be a string.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Email must be a valid email address.',
            'email.unique'      => 'Email is already in the system.',
            'admin.required'    => 'Staff type is required.',
            'admin.boolean'     => 'Staff type must be either regular or admin.',
            'centres.required'  => 'Centre is required.',
            'centres.array'     => 'Centre is required.',
        ];
    }
}
