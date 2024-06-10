<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:100|regex:/^[а-яА-ЯЁё\s]/i',
            'email' => 'required|min:5|max:50|email:rfc',
            'phone' => 'required|min:5|max:20|regex:/^[0-9\+]/i',
            'telegram' => 'required|min:5|max:15|regex:/^[a-zA-Z0-9_@]/i',
            'agree' => 'sometimes|in:on,1'
        ];
    }
}
