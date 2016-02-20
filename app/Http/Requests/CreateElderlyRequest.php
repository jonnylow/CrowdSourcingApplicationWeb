<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateElderlyRequest extends Request
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
     * Validation rules used for storing of elderly.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'centre'            => 'required',
            'nric'              => 'required|regex:/^[STFGstfg][0-9]{7}[a-zA-Z]$/|unique:elderly,nric,null,elderly_id',
            'name'              => 'required|alpha_space',
            'gender'            => 'required|in:M,F',
            'birth_year'        => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'languages'         => 'required|array',
            'medical_condition' => 'string',
            'nok_name'          => 'required|alpha_space',
            'nok_contact'       => 'required|digits:8|regex:/^[689][0-9]{7}/',
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
            'centre.required'           => 'Centre is required.',
            'nric.required'             => 'NRIC is required.',
            'nric.regex'                => 'NRIC is invalid.',
            'nric.unique'               => 'NRIC has been taken.',
            'name.required'             => 'Name is required.',
            'name.alpha_space'          => 'Name must contain only letters or spaces.',
            'gender.required'           => 'Gender is required.',
            'gender.in'                 => 'Gender must be either male or female.',
            'birth_year.required'       => 'Birth year is required.',
            'birth_year.integer'        => 'Birth year must be a number.',
            'birth_year.digits'         => 'Birth year must be 4 digits.',
            'birth_year.min'            => 'Birth year must not be before 1900.',
            'birth_year.max'            => 'Birth year must not be after ' . date('Y') . '.',
            'languages.required'        => 'Language is required.',
            'languages.array'           => 'Language is required.',
            'medical_condition.string'  => 'Medical condition must be a string.',
            'nok_name.required'         => 'NOK\'s name is required.',
            'nok_name.alpha_space'      => 'NOK\'s name must contain only letters or spaces.',
            'nok_contact.required'      => 'Contact number is required.',
            'nok_contact.digits'        => 'Contact number must be 8 digits.',
            'nok_contact.regex'         => 'Contact number must starts with 6, 8, or 9.',
        ];
    }
}
