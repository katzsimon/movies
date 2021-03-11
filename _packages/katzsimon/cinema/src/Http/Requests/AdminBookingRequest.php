<?php

namespace Katzsimon\Cinema\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminBookingRequest extends FormRequest
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
            'user_id'=>['required', 'integer', 'min:1'],
            'screening_id'=>['required', 'integer', 'min:1'],
            'seats'=>['required', 'integer', 'min:0'],
            'reference'=>[],
        ];
    }
}
