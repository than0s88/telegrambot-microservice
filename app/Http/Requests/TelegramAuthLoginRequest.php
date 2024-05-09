<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelegramAuthLoginRequest extends FormRequest
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
            'id' => 'required',
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'username' => 'sometimes',
            'photo_url' => 'sometimes',
            'auth_date' => 'sometimes',
            'hash' => 'required',
            'bot_name' => 'sometimes'
        ];
    }
}
