<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VolunteerRequest extends Request
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
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            // Update operation, exclude the record with id from the validation:
            $nric_rule = 'required|regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:volunteers,nric,' . $this->get('volunteer_id') . ',volunteer_id';
            $email_rule = 'required|email|unique:volunteers,email,' . $this->get('volunteer_id') . ',volunteer_id';
        } else {
            // Create operation. There is no id yet.
            $nric_rule = 'required|regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:volunteers,nric,null,volunteer_id';
            $email_rule = 'required|email|unique:volunteers,email,null,volunteer_id';
        }

        return [
            'nric'                  => $nric_rule,
            'name'                  => 'required|string',
            'email'                 => $email_rule,
            'gender'                => 'required|in:M,F',
            'date_of_birth'         => 'required|date|before:today',
            'contact_no'            => 'required|digits:8',
            'occupation'            => 'required|string',
            'car'                   => 'required|boolean',
            'minutes_volunteered'   => 'required|numeric|min:0|max:99999999',
            'area_of_preference_1'  => 'required|string',
            'area_of_preference_2'  => 'required|string',
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
            'nric.required'                 => 'NRIC is required.',
            'nric.regex'                    => 'NRIC is invalid.',
            'nric.unique'                   => 'NRIC is already in the system.',
            'name.required'                 => 'Name is required.',
            'name.string'                   => 'Name must be a string.',
            'email.required'                => 'Email is required.',
            'email.email'                   => 'Email must be a valid email address.',
            'email.unique'                  => 'Email is already in the system.',
            'gender.required'               => 'Gender is required.',
            'gender.in'                     => 'Gender must be either male or female.',
            'date_of_birth.required'        => 'Date of birth is required.',
            'date_of_birth.date'            => 'Date of birth must be a valid date.',
            'date_of_birth.before'          => 'Date of birth must be before today.',
            'contact_no.required'           => 'Contact number is required.',
            'contact_no.digits'             => 'Contact number must be 8 digits.',
            'occupation.required'           => 'Occupation is required.',
            'occupation.string'             => 'Occupation must be a string.',
            'car.required'                  => 'Car ownership is required.',
            'car.boolean'                   => 'Car ownership must either has or do not has car.',
            'minutes_volunteered.required'   => 'Total time volunteered is required.',
            'minutes_volunteered.numeric'    => 'Total time volunteered must be in number.',
            'minutes_volunteered.min'        => 'Total time volunteered must be at least 0 minutes.',
            'minutes_volunteered.max'        => 'Total time volunteered must be less than 99,999,999 minutes.',
            'area_of_preference_1.required' => 'Volunteering Preference 1 is required.',
            'area_of_preference_1.string'   => 'Volunteering Preference 1 must be a string.',
            'area_of_preference_2.required' => 'Volunteering Preference 2 is required.',
            'area_of_preference_2.string'   => 'Volunteering Preference 2 must be a string.',
        ];
    }
}
