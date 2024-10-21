<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrderStatusRequest extends FormRequest
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
        return [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'persage' => 'required|numeric|min:0|max:100|unique:order_status,persage',
            'backgroud_color' => 'required|string|size:7', // Color hex codes are typically 7 characters long
        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'The Arabic title field is required.',
            'title_ar.string' => 'The Arabic title must be a string.',
            'title_ar.max' => 'The Arabic title may not be greater than 255 characters.',
            'title_en.required' => 'The English title field is required.',
            'title_en.string' => 'The English title must be a string.',
            'title_en.max' => 'The English title may not be greater than 255 characters.',
            'persage.required' => 'The percentage field is required.',
            'persage.numeric' => 'The percentage must be a number.',
            'persage.min' => 'The percentage must be at least 0.',
            'persage.max' => 'The percentage may not be greater than 100.',
            'persage.unique' => 'The percentage must be unique.',
            'backgroud_color.required' => 'The background color field is required.',
            'backgroud_color.string' => 'The background color must be a valid hex code.',
            'backgroud_color.size' => 'The background color must be a valid hex code of 7 characters including the #.',
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
