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
            'date_month'            => 'required|between:1,12',
            'date_day'              => 'required|digits_between:1,2|between:1,31',
            'date_year'             => 'required|integer|digits:4|min:' . date('Y'),
            'time_hour'             => 'required|digits_between:1,2|between:1,12',
            'time_minute'           => 'required|digits_between:1,2|between:0,59',
            'time_period'           => 'required|in:AM,PM',
            'duration_hour'         => 'required|digits_between:1,2|between:0,10',
            'duration_minute'       => 'required|digits_between:1,2|between:0,59',
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

            // Custom added in 'validate' method
            'date'                  => 'required|date_format:Y-m-d|after:today',
            'time'                  => 'required|date_format:h:i A',
            'duration'              => 'required|integer|min:30',
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
                'date' => $combinedDate,
            ]);
        }

        if (is_string($this->get('time_hour')) && is_string($this->get('time_minute')) && is_string($this->get('time_period'))) {
            $combinedTime = str_pad($this->get('time_hour'), 2, '0', STR_PAD_LEFT) . ":" . str_pad($this->get('time_minute'), 2, '0', STR_PAD_LEFT) . " " . $this->get('time_period');
            $this->merge([
                'time' => $combinedTime,
            ]);
        }

        if (is_integer((int)$this->get('duration_hour')) && is_integer((int)$this->get('duration_minute'))) {
            $combinedDuration = (int)$this->get('duration_hour') * 60 + (int)$this->get('duration_minute');
            $this->merge([
                'duration' => $combinedDuration,
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
            'centre.required'                   => 'Centre is required.',
            'date_month.required'               => 'Month is required.',
            'date_month.between'                => 'Month must be between January to December.',
            'date_day.required'                 => 'Day is required.',
            'date_day.digits_between'           => 'Day must be 1 or 2 digits.',
            'date_day.between'                  => 'Day must be between 1 to 31.',
            'date_year.required'                => 'Year is required.',
            'date_year.integer'                 => 'Year must be a number.',
            'date_year.digits'                  => 'Year must be 4 digits.',
            'date_year.min'                     => 'Year must be at least ' . date('Y') . '.',
            'time_hour.required'                => 'Hour is required.',
            'time_hour.digits_between'          => 'Hour must be 1 or 2 digits.',
            'time_hour.between'                 => 'Hour must be between 1 to 12.',
            'time_minute.required'              => 'Minute is required.',
            'time_minute.digits_between'        => 'Minute must be 1 or 2 digits.',
            'time_minute.between'               => 'Minute must be between 0 to 59.',
            'time_period.required'              => 'AM/PM is required.',
            'time_period.in'                    => 'AM/PM is required.',
            'duration_hour.required'            => 'Hour is required.',
            'duration_hour.digits_between'      => 'Hour must be 1 or 2 digits.',
            'duration_hour.between'             => 'Hour must be between 0 to 10.',
            'duration_minute.required'          => 'Minute is required.',
            'duration_minute.digits_between'    => 'Minute must be 1 or 2 digits.',
            'duration_minute.between'           => 'Minute must be between 0 to 59.',
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

            // Custom added in 'validate' method
            'date.required'                     => 'Date is required.',
            'date.date_format'                  => 'Date is invalid.',
            'date.after'                        => 'Date must be after today.',
            'time.required'                     => 'Time is required.',
            'time.date_format'                  => 'Time is invalid.',
            'duration.required'                 => 'Duration is required.',
            'duration.integer'                  => 'Duration must be a number.',
            'duration.min'                      => 'Duration must be at least 30 minutes.',
        ];
    }
}
