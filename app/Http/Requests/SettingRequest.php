<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "logo"        => "required|image",
            "name"        => "required|string",
            "description" => "required|string",
            "instagram"   => "required|string|url",
            "whatsApp"    => "required|string|url",
            "facebook"    => "required|string|url",
            "email"       => "required|string|email",
            "phone"       => "required|string"
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['logo'] = 'nullable|image';
        }

        return $rules;

    }
}
