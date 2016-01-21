<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePasswordRequest extends Request
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
            'current_password'          => 'required',
            'new_password'              => 'required|different:current_password',
            'new_password_confirmation' => 'required|same:new_password',
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
            'current_password.required'             => 'You must enter your current password to make any changes.',
            'new_password.required'                 => 'New password is required.',
            'new_password.different'                => 'New password must be different from current one.',
            'new_password_confirmation.required'    => 'Password must be confirmed.',
            'new_password_confirmation.same'        => 'Passwords do not match.',
        ];
    }
}
