<?php

namespace Katzsimon\Cinema\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminTheatreRequest extends FormRequest
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
            'cinema_id'=>['required', 'integer', function ($attribute, $value, $fail) {
                if ($value === '' || $value==='0') {
                    $fail('The Cinema is invalid.');
                }
            }],
            'name'=>['required', 'min:3'],
            'max_seats'=>['required', 'integer', 'min:5', 'max:30'],
        ];
    }

}
