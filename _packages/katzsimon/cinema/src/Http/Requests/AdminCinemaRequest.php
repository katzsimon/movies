<?php

namespace Katzsimon\Cinema\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCinemaRequest extends FormRequest
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
            'location'=>['required', 'min:3'],
            'name'=>['required', 'min:3', 'unique:cinemas,id,'.$this->id],
        ];
    }
}
