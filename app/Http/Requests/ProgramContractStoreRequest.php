<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProgramContractStoreRequest extends FormRequest
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
            'contract' => 'string|required_without:pdf|nullable',
            'pdf' => 'file|required_without:contract',
            'program_id' => 'required|exists:programs,id'
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
            'contract.string' => 'The contract must be a string.',
            'contract.required_without' => 'The contract field is required when PDF is not present.',
            'pdf.file' => 'The PDF must be a file.',
            'pdf.required_without' => 'The PDF field is required when contract is not present.',
            'program_id.required' => 'The program field is required.',
            'program_id.exists' => 'The selected program does not exist.',
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
