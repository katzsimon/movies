<?php

namespace Katzsimon\Cinema\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppBookingRequest extends FormRequest
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
            'movie_id'=>['required', 'integer'],
            'screening_id'=>['required', 'integer'],
            'seats'=>['required', 'integer', 'min:0'],
        ];
    }
}
