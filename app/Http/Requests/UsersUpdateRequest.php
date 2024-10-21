<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules;

class UsersUpdateRequest extends FormRequest
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
    public function rules()
{
    $id = $this->request->get('id'); // Get the ID from the request

    return [
        'name' => 'required|string|max:255',
        'email' => 'required|email|string|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8|max:100',
        'logo' => 'nullable|image',
        'status' => 'required|boolean',
        'id'=>'min:2'
    ];
}

public function messages()
{
    return [
        'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a string.',
        'name.max' => 'The name may not be greater than 255 characters.',
        'email.required' => 'The email field is required.',
        'email.string' => 'The email must be a string.',
        'email.email' => 'The email must be a valid email address.',
        'email.max' => 'The email may not be greater than 255 characters.',
        'email.unique' => 'The email has already been taken.',
        'password.string' => 'The password must be a string.',
        'password.min' => 'The password must be at least 8 characters.',
        'password.max' => 'The password may not be greater than 100 characters.',
        'status.required' => 'The status field is required.',
        'status.boolean' => 'The status field must be true or false.',
        'logo.image' => 'The logo must be an image.',
        'id.min'=>'not allow'
    ];
}
protected function failedValidation(Validator $validator)
{
    $errorMessages = $validator->errors()->all();

    // Display each error message with Toastr
    foreach ($errorMessages as $errorMessage) {
        Toastr::error($errorMessage, __('validation_custom.Error'));
    }

    parent::failedValidation($validator);
}
}
