<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class UpdateProfileRequest extends Request
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
     * Validation rules used for editing of user profile.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                      => 'required|name',
            'email'                     => 'required|email|unique:staff,email,'.Auth::user()->staff_id.',staff_id',
            'current_password'          => 'required',
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
            'name.required'                         => 'Name is required.',
            'name.name'                             => 'Name must contain only alphabets, commas, hyphens, or slashes.',
            'email.required'                        => 'Email address is required.',
            'email.email'                           => 'Email address is invalid',
            'email.unique'                          => 'Email address has been taken.',
            'current_password.required'             => 'You must enter your current password to make any changes.',
        ];
    }
}
