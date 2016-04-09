<?php

namespace App\Http\Requests;


class RankRequest extends Request
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
     * Validation rules used for storing of rank.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rank_1'    => 'required|integer|min:3|max:65535',
            'rank_2'    => 'required|integer|min:2|max:65534',
            'rank_3'    => 'required|integer|min:1|max:65533',
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
            'rank_1.required'   => 'Point for rank 1 is required.',
            'rank_1.integer'    => 'Point for rank 1 must be a number.',
            'rank_1.min'        => 'Point for rank 1 must be more than 2.',
            'rank_1.max'        => 'Point for rank 1 must be less than 65536.',
            'rank_2.required'   => 'Point for rank 2 is required.',
            'rank_2.integer'    => 'Point for rank 2 must be a number.',
            'rank_2.min'        => 'Point for rank 2 must be more than 1.',
            'rank_2.max'        => 'Point for rank 2 must be less than 65535.',
            'rank_3.required'   => 'Point for rank 3 is required.',
            'rank_3.integer'    => 'Point for rank 3 must be a number.',
            'rank_3.min'        => 'Point for rank 3 must be more than 0.',
            'rank_3.max'        => 'Point for rank 3 must be less than 65534.',
        ];
    }
}
