<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class UpdateUserRequest extends FormRequest
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
            'edit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1502048', // Ajusta según tus necesidades
            'edit_name' => 'required|string|max:255',
            'edit_lastname' => 'required|string|max:255',
            'edit_role' => 'required|string|max:255',
            'edit_phone' => 'nullable|string|max:255',
            'edit_mobile' => 'nullable|string|max:255',
            'edit_address' => 'nullable|string|max:255',
            'edit_location' => 'nullable|string|max:255',
            'edit_email' => 'nullable|string|email|max:255',
        ];
    }
}
