<?php

namespace App\Http\Requests;

use App\Rules\AllowedAttributes;
use Illuminate\Foundation\Http\FormRequest;

class FormForForm extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*' => [new AllowedAttributes(['qwer'])],
        ];
    }
}
