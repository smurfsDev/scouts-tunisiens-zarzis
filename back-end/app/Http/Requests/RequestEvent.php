<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEvent extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'titre'=>"required|max:10|min:5|unique:events",
            'description'=>"required|max:255|min:8",
            'location'=>"required",
            'date_debut'=>"required|date",
            'date_fin'=>"required|date",
        ];
    }
}
