<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ElderlyRequest extends Request
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
            'name'              => 'required|string',
            'gender'            => 'required|in:M,F',
            'birth_year'        => 'required|digits:4',
            'languages'         => 'required|array',
//            'photo'             => 'mimes:jpeg,jpg,png,gif,tiff|max:1024',
            'medical_condition' => 'string',
            'nok_name'          => 'required|string',
            'nok_contact'       => 'required|digits:8',
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
            'nric.unique'               => 'NRIC is already in the system.',
            'name.required'             => 'Name is required.',
            'name.string'               => 'Name must be a string.',
            'gender.required'           => 'Gender is required.',
            'gender.in'                 => 'Gender must be either male or female.',
            'birth_year.required'       => 'Birth year is required.',
            'birth_year.digits'         => 'Birth year must be 4 digits.',
            'languages.required'        => 'Language is required.',
            'languages.array'           => 'Language is required.',
            'nok_name.required'         => 'NOK\'s name is required.',
//            'photo.mimes'               => 'Photo must be saved as JPG, PNG, GIF or TIFF files.',
//            'photo.max'                 => 'Photo must be less than 1 MB.',
            'medical_condition.string'  => 'Medical condition must be a string.',
            'nok_name.string'           => 'NOK\'s name must be a string.',
            'nok_contact.required'      => 'Contact number is required.',
            'nok_contact.digits'        => 'Contact number must be 8 digits.',
        ];
    }
}
