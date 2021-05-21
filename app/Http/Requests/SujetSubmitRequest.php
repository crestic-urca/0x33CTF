<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SujetSubmitRequest extends FormRequest
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
            'titre' => 'required|min:5|max:100',
            'enonce' => 'required|max:60000',
            'flag' => 'required',
            'nb_points' => 'required|min:0|max:2147483647' ,
            'nb_try' => 'required|min:0|max:2147483647' ,
            'categorie_id' => 'required|exists:categorie,id',
        ];
    }
}
