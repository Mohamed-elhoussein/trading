<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProgramsTypesUpdateRequest extends FormRequest
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
            'id' => 'required|exists:program_types,id'

        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'The Arabic month field is required.',
            'title_ar.string' => 'The Arabic month must be a string.',
            'title_ar.max' => 'The Arabic month may not be greater than 255 characters.',
            'title_en.required' => 'The English month field is required.',
            'title_en.string' => 'The English month must be a string.',
            'title_en.max' => 'The English month may not be greater than 255 characters.',
            'id.required' => 'The ID field is required.',
            'id.exists' => 'The selected ID is invalid.',
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
