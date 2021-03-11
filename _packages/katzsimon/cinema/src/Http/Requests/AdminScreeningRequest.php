<?php

namespace Katzsimon\Cinema\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminScreeningRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'theatre_id'=>['required', 'integer', 'min:1'],
            'movie_id'=>['required', 'integer', 'min:1'],
            'datetime'=>['required', 'date_format:Y-m-d H:i'],
            //'time'=>['required', 'date_format:H:i'],
        ];
    }
}
