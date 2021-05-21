<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            "name" => 'required',
            "date_start" => 'required|date|after:yesterday',
            "date_end" => 'required|date|after:yesterday',
            "date_start_time" => 'required',
            "date_start_time" => 'required',
            "email_verification" => '',
            "use_limitation_players_per_team" => '',
            "max_players_per_team" => 'numeric|min:1|max:2147483647',
            "description" => 'max:65000',
        ];
    }
}
