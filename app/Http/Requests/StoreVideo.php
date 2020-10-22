<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|max:250',
            'email' => 'required|max:250',
            'telephone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'band' => 'required|max:250',
            'genre' => 'required|max:250',
            'location' => 'required|max:250',
            'file'  => 'required|mimes:mp4,mov,ogg | max:20000'
        ];
    }
}
// 'file' => 'required|mimes:mp4,mov,ogg,qt,flv,ts,3gp,avi,wmv | max:20000'