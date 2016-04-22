<?php

namespace App\Http\Requests;


/**
 * Form requests class that contains validation logic when editing activity.
 *
 * @package App\Http\Requests
 */
class EditActivityRequest extends Request
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
     * Validation rules used when editing activity.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'centre'                => 'required',
            'date_month'            => 'required|between:1,12',
            'date_day'              => 'required|integer_between:1,31',
            'date_year'             => 'required|integer|digits:4|min:' . date('Y'),
            'time_hour'             => 'required|integer_between:1,12',
            'time_minute'           => 'required|integer_digits_and_between:2,0,59',
            'time_period'           => 'required|in:AM,PM',
            'duration_hour'         => 'required|integer_between:0,10',
            'duration_minute'       => 'required|integer_between:0,59',
            'more_information'      => 'string',
            'start_location'        => 'required',
            'start_location_name'   => 'alpha_num_space|unique:centres,name,null,centre_id|different:end_location_name|required_if:start_location,others',
            'start_postal'          => 'digits:6|required_if:start_location,others',
            'end_location'          => 'required',
            'end_location_name'     => 'alpha_num_space|unique:centres,name,null,centre_id|different:start_location_name|required_if:end_location,others',
            'end_postal'            => 'digits:6|required_if:end_location,others',
            'senior'                => 'required',
            'senior_nric'           => 'regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:elderly,nric,null,elderly_id|required_if:senior,others',
            'senior_name'           => 'alpha_space|required_if:senior,others',
            'senior_gender'         => 'in:M,F|required_if:senior,others',
            'senior_birth_year'     => 'integer|digits:4|min:1900|max:' . date('Y') . '|required_if:senior,others',
            'languages'             => 'array|required_if:senior,others',
            'senior_nok_name'       => 'alpha_space|required_if:senior,others',
            'senior_nok_contact'    => 'digits:8|regex:/^[689][0-9]{7}/|required_if:senior,others',
            'senior_medical'        => 'string',

            // Custom added in 'validate' method
            'date'                  => 'required|date_format:Y-m-d|after:today',
            'time'                  => 'required|date_format:h:i A',
            'duration'              => 'required|integer|min:30',
        ];
    }

    /**
     * Custom validation by overwriting the validate function.
     * 
     * @return
     */
    public function validate()
    {
        // Format the date fields: month, date and year, into a date string (e.g. 2000-01-31)
        if (is_string($this->get('date_month')) && is_string($this->get('date_day')) && is_string($this->get('date_year'))) {
            $combinedDate = implode('-', [$this->get('date_year'), str_pad($this->get('date_month'), 2, '0', STR_PAD_LEFT), str_pad($this->get('date_day'), 2, '0', STR_PAD_LEFT)]);
            $this->merge([
                'date' => $combinedDate,
            ]);
        }

        // Format the time fields: hour, minute and period, into a time string (e.g. 08:05 am)
        if (is_string($this->get('time_hour')) && is_string($this->get('time_minute')) && is_string($this->get('time_period'))) {
            $combinedTime = str_pad($this->get('time_hour'), 2, '0', STR_PAD_LEFT) . ":" . str_pad($this->get('time_minute'), 2, '0', STR_PAD_LEFT) . " " . $this->get('time_period');
            $this->merge([
                'time' => $combinedTime,
            ]);
        }

        // Convert the activity duration into minutes
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
            'centre.required'                           => 'Centre is required.',
            'date_month.required'                       => 'Month is required.',
            'date_month.between'                        => 'Month must be between January to December.',
            'date_day.required'                         => 'Day is required.',
            'date_day.integer_between'                  => 'Day must be between 1 to 31.',
            'date_year.required'                        => 'Year is required.',
            'date_year.integer'                         => 'Year must be a number.',
            'date_year.digits'                          => 'Year must be 4 digits.',
            'date_year.min'                             => 'Year must be at least ' . date('Y') . '.',
            'time_hour.required'                        => 'Hour is required.',
            'time_hour.integer_between'                 => 'Hour must be between 1 to 12.',
            'time_minute.required'                      => 'Minute is required.',
            'time_minute.integer_digits_and_between'    => 'Minute must be a 2-digit number between 00 to 59.',
            'time_period.required'                      => 'AM/PM is required.',
            'time_period.in'                            => 'AM/PM is required.',
            'duration_hour.required'                    => 'Hour is required.',
            'duration_hour.integer_between'             => 'Hour must be between 0 to 10.',
            'duration_minute.required'                  => 'Minute is required.',
            'duration_minute.integer_between'           => 'Minute must be between 0 to 59.',
            'more_information.string'                   => 'Additional information must be a string.',
            'start_location.required'                   => 'Branch is required.',
            'start_location_name.alpha_num_space'       => 'Name for branch must contain only letters, numbers, or spaces.',
            'start_location_name.unique'                => 'Branch is already in the system.',
            'start_location_name.required_if'           => 'Name for branch is required.',
            'start_postal.digits'                       => 'Postal code for branch must be 6 digits.',
            'start_postal.required_if'                  => 'Postal code for branch is required.',
            'end_location.required'                     => 'Appointment venue is required.',
            'end_location_name.alpha_num_space'         => 'Name for appointment venue must contain only letters, numbers, or spaces.',
            'end_location_name.unique'                  => 'Appointment venue is already in the system.',
            'end_location_name.required_if'             => 'Name for appointment venue is required.',
            'end_postal.digits'                         => 'Postal code for appointment venue must be 6 digits.',
            'end_postal.required_if'                    => 'Postal code for appointment venue is required.',
            'senior.required'                           => 'Senior is required.',
            'senior_nric.regex'                         => 'Senior\'s NRIC is invalid.',
            'senior_nric.unique'                        => 'Senior\'s NRIC has been taken.',
            'senior_nric.required_if'                   => 'Senior\'s NRIC is required.',
            'senior_name.alpha_space'                   => 'Senior\'s name must contain only letters or spaces.',
            'senior_name.required_if'                   => 'Senior\'s name is required.',
            'senior_gender.in'                          => 'Senior\'s gender must be either male or female.',
            'senior_gender.required_if'                 => 'Senior\'s gender is required.',
            'senior_birth_year.integer'                 => 'Senior\'s birth year must be a number.',
            'senior_birth_year.digits'                  => 'Senior\'s birth year must be 4 digits.',
            'senior_birth_year.min'                     => 'Senior\'s birth year must not be before 1900.',
            'senior_birth_year.max'                     => 'Senior\'s birth year must not be after ' . date('Y') . '.',
            'senior_birth_year.required_if'             => 'Senior\'s birth year is required.',
            'languages.array'                           => 'Language is required.',
            'languages.required_if'                     => 'Language is required.',
            'senior_nok_name.alpha_space'               => 'NOK\'s name must contain only letters or spaces.',
            'senior_nok_name.required_if'               => 'NOK\'s name is required.',
            'senior_nok_contact.digits'                 => 'Contact number must be 8 digits.',
            'senior_nok_contact.regex'                  => 'Contact number must starts with 6, 8, or 9.',
            'senior_nok_contact.required_if'            => 'Contact number is required.',
            'senior_medical.string'                     => 'Medical condition must be a string.',

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
