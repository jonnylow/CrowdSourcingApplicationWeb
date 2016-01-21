<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateVolunteerRequest extends Request
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
     * Validation rules used for storing of volunteer.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nric'                  => 'required|regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:volunteers,nric,null,volunteer_id',
            'name'                  => 'required|name',
            'email'                 => 'required|email|unique:volunteers,email,null,volunteer_id',
            'gender'                => 'required|in:M,F',
            'date_of_birth'         => 'required|date|before:today',
            'contact_no'            => 'required|digits:8|regex:/^[689][0-9]{7}/',
            'occupation'            => 'required|string',
            'car'                   => 'required|boolean',
            'area_of_preference_1'  => 'required|string',
            'area_of_preference_2'  => 'required|string',
        ];

        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            // Update operation, exclude the record with id from the validation:
            $rules['nric'] = 'required|regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:volunteers,nric,' . $this->get('volunteer_id') . ',volunteer_id';
            $rules['email'] = 'required|email|unique:volunteers,email,' . $this->get('volunteer_id') . ',volunteer_id';
            $rules['minutes_volunteered'] = 'required|numeric|min:0|max:99999999';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nric.required'                 => 'NRIC is required.',
            'nric.regex'                    => 'NRIC is invalid.',
            'nric.unique'                   => 'NRIC has been taken.',
            'name.required'                 => 'Name is required.',
            'name.name'                     => 'Name must contain only alphabets, commas, hyphens, or slashes.',
            'email.required'                => 'Email address is required.',
            'email.email'                   => 'Email address is invalid.',
            'email.unique'                  => 'Email address has been taken.',
            'gender.required'               => 'Gender is required.',
            'gender.in'                     => 'Gender must be either male or female.',
            'date_of_birth.required'        => 'Date of birth is required.',
            'date_of_birth.date'            => 'Date of birth must be a valid date.',
            'date_of_birth.before'          => 'Date of birth must be before today.',
            'contact_no.required'           => 'Contact number is required.',
            'contact_no.digits'             => 'Contact number must be 8 digits.',
            'contact_no.regex'              => 'Contact number must starts with 6, 8, or 9.',
            'occupation.required'           => 'Occupation is required.',
            'occupation.string'             => 'Occupation must be a string.',
            'car.required'                  => 'Car ownership is required.',
            'car.boolean'                   => 'Car ownership must either has or do not has car.',
            'area_of_preference_1.required' => 'Volunteering Preference 1 is required.',
            'area_of_preference_1.string'   => 'Volunteering Preference 1 must be a string.',
            'area_of_preference_2.required' => 'Volunteering Preference 2 is required.',
            'area_of_preference_2.string'   => 'Volunteering Preference 2 must be a string.',
        ];
    }
}
