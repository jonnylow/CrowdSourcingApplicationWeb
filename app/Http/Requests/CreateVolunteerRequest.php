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
            'name'                  => 'required|alpha_space',
            'email'                 => 'required|email|unique:volunteers,email,null,volunteer_id',
            'gender'                => 'required|in:M,F',
            'date_month'            => 'required|between:1,12',
            'date_month'            => 'required|between:1,12',
            'date_day'              => 'required|integer_between:1,31',
            'date_year'             => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'contact_no'            => 'required|digits:8|regex:/^[689][0-9]{7}/',
            'occupation'            => 'required|alpha',
            'car'                   => 'required|boolean',
            'area_of_preference_1'  => 'required|string|different:area_of_preference_2',
            'area_of_preference_2'  => 'required|string|different:area_of_preference_1',

            // Custom added in 'validate' method
            'date_of_birth'         => 'required|date_format:Y-m-d|before:today',
        ];
    }

    /**
     * Validate request
     * @return
     */
    public function validate()
    {
        if (is_string($this->get('date_month')) && is_string($this->get('date_day')) && is_string($this->get('date_year'))) {
            $combinedDate = implode('-', [$this->get('date_year'), str_pad($this->get('date_month'), 2, '0', STR_PAD_LEFT), str_pad($this->get('date_day'), 2, '0', STR_PAD_LEFT)]);
            $this->merge([
                'date_of_birth' => $combinedDate,
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
            'nric.required'                     => 'NRIC is required.',
            'nric.regex'                        => 'NRIC is invalid.',
            'nric.unique'                       => 'NRIC has been taken.',
            'name.required'                     => 'Name is required.',
            'name.alpha_space'                  => 'Name must contain only letters or spaces.',
            'email.required'                    => 'Email address is required.',
            'email.email'                       => 'Email address is invalid.',
            'email.unique'                      => 'Email address has been taken.',
            'gender.required'                   => 'Gender is required.',
            'gender.in'                         => 'Gender must be either male or female.',
            'date_month.required'               => 'Month is required.',
            'date_month.between'                => 'Month must be between January to December.',
            'date_day.required'                 => 'Day is required.',
            'date_day.integer_between'          => 'Day must be between 1 to 31.',
            'date_year.required'                => 'Year is required.',
            'date_year.integer'                 => 'Year must be a number.',
            'date_year.digits'                  => 'Year must be 4 digits.',
            'date_year.min'                     => 'Year must be at least 1900.',
            'date_year.max'                     => 'Year must be at most ' . date('Y') . '.',
            'contact_no.required'               => 'Contact number is required.',
            'contact_no.digits'                 => 'Contact number must be 8 digits.',
            'contact_no.regex'                  => 'Contact number must starts with 6, 8, or 9.',
            'occupation.required'               => 'Occupation is required.',
            'occupation.alpha'                  => 'Occupation must contain only letters.',
            'car.required'                      => 'Car ownership is required.',
            'car.boolean'                       => 'Car ownership must either has or do not has car.',
            'area_of_preference_1.required'     => 'Volunteering Preference 1 is required.',
            'area_of_preference_1.string'       => 'Volunteering Preference 1 must be a string.',
            'area_of_preference_1.different'    => 'Volunteering Preferences cannot be the same.',
            'area_of_preference_2.required'     => 'Volunteering Preference 2 is required.',
            'area_of_preference_2.string'       => 'Volunteering Preference 2 must be a string.',
            'area_of_preference_2.different'    => 'Volunteering Preferences cannot be the same.',

            // Custom added in 'validate' method
            'date_of_birth.required'        => 'Date of birth is required.',
            'date_of_birth.date_format'     => 'Date of birth must be a valid date.',
            'date_of_birth.before'          => 'Date of birth must be before today.',
        ];
    }
}
