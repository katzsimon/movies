<?php

namespace Katzsimon\Movie\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminMovieRequest extends FormRequest
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
            'name'=>['required', 'min:3'],
            'genre'=>['required', 'min:3'],
            'runtime'=>['required', 'integer'],
            'description'=>['required', 'min:3'],
            'rating'=>['required', 'integer', 'min:0', 'max:5'],
            'starring'=>[]
        ];
    }
}
