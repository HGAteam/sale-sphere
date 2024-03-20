<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cuit' => 'required|string|max:20',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas según tus necesidades
            'central_location' => 'sometimes|string|max:255',
            'location_code' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'mobile' => 'sometimes|string|max:20',
        ];
    }
}
