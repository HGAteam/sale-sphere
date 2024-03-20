<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class CreateUserRequest extends FormRequest
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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:1502048', // Ajusta según tus necesidades
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'address' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users', // Asegura que el correo electrónico sea único en la tabla de usuarios.
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
