<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            'name' => 'required | min: 3 | distinct',
            'description' => 'required | min: 10',
            'slug' => 'required',
            'release_date' => 'required | date',
            'rating' => 'required | integer | between: 1,5',
            'ticket_price' => 'required | numeric',
            'country' => 'required | min: 3',
            'genre' => 'required | min: 3',
            'film_photo' => 'required',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Film name is required',
        ]; 
    }
}
