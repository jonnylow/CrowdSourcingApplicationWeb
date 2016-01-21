<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityRequest extends Request
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
     * Validation rules used for storing of activity.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'centre'                => 'required',
            'date'                  => 'required|date|after:today',
            'time_to_start'         => 'required',
            'duration'              => 'required|numeric|min:1',
            'more_information'      => 'string',
            'start_location'        => 'required',
            'start_location_name'   => 'string|required_if:start_location,others',
            'start_postal'          => 'digits:6|required_if:start_location,others',
            'end_location'          => 'required',
            'end_location_name'     => 'string|required_if:end_location,others',
            'end_postal'            => 'digits:6|required_if:end_location,others',
            'senior'                => 'required',
            'senior_nric'           => 'regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:elderly,nric,null,elderly_id|required_if:senior,others',
            'senior_name'           => 'name|required_if:senior,others',
            'senior_gender'         => 'in:M,F|required_if:senior,others',
            'senior_birth_year'     => 'digits:4|min:1900|required_if:senior,others',
            'languages'             => 'array|required_if:senior,others',
            'senior_nok_name'       => 'name|required_if:senior,others',
            'senior_nok_contact'    => 'digits:8|regex:/^[689][0-9]{7}/|required_if:senior,others',
            'senior_medical'        => 'string',
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
            'centre.required'                   => 'Centre is required.',
            'date.required'                     => 'Date is required.',
            'date.date'                         => 'Date must be a valid date.',
            'date.after'                        => 'Date must be after today.',
            'time_to_start.required'            => 'Time is required.',
            'duration.required'                 => 'Duration is required.',
            'duration.numeric'                  => 'Duration must be a number.',
            'duration.min'                      => 'Duration must be at least 1 hour.',
            'more_information.string'           => 'Additional information must be a string.',
            'start_location.required'           => 'Start location is required.',
            'start_location_name.string'        => 'Name for start location must be a string.',
            'start_location_name.required_if'   => 'Name for start location is required.',
            'start_postal.digits'               => 'Postal code for start location must be 6 digits.',
            'start_postal.required_if'          => 'Postal code for start location is required.',
            'end_location.required'             => 'End location is required.',
            'end_location_name.string'          => 'Name for end location must be a string.',
            'end_location_name.required_if'     => 'Name for end location is required.',
            'end_postal.digits'                 => 'Postal code for end location must be 6 digits.',
            'end_postal.required_if'            => 'Postal code for end location is required.',
            'senior.required'                   => 'Senior is required.',
            'senior_nric.regex'                 => 'Senior\'s NRIC is invalid.',
            'senior_nric.unique'                => 'Senior\'s has been taken.',
            'senior_nric.required_if'           => 'Senior\'s NRIC is required.',
            'senior_name.name'                  => 'Senior\'s name must contain only alphabets, commas, hyphens, or slashes.',
            'senior_name.required_if'           => 'Senior\'s name is required.',
            'senior_gender.in'                  => 'Senior\'s gender must be either male or female.',
            'senior_gender.required_if'         => 'Senior\'s gender is required.',
            'senior_birth_year.digits'          => 'Senior\'s birth year must be 4 digits.',
            'senior_birth_year.min'             => 'Senior\'s birth year must not be before 1900.',
            'senior_birth_year.required_if'     => 'Senior\'s birth year is required.',
            'languages.array'                   => 'Language is required.',
            'languages.required_if'             => 'Language is required.',
            'senior_nok_name.name'              => 'NOK\'s name must contain only alphabets, commas, hyphens, or slashes.',
            'senior_nok_name.required_if'       => 'NOK\'s name is required.',
            'senior_nok_contact.digits'         => 'Contact number must be 8 digits.',
            'senior_nok_contact.regex'          => 'Contact number must starts with 6, 8, or 9.',
            'senior_nok_contact.required_if'    => 'Contact number is required.',
            'senior_medical.string'             => 'Medical condition must be a string.',
        ];
    }
}
