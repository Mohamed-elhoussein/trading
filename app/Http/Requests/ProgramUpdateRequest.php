<?php

namespace App\Http\Requests;


use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProgramUpdateRequest extends FormRequest
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
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'calender_ar' => 'required|string|max:255',
            'calender_en' => 'required|string|max:255',
            'interest_ar'=>  'required|string|max:255',
            'interest_en'=>  'required|string|max:255',
            'program_type_id' => 'required|numeric|min:1|exists:program_types,id',
            'value'=>'required|numeric|min:0',
            'id' => 'required|exists:programs,id'

        ];
    }

    public function messages()
    {
        return [
            'description_ar.required' => 'The Arabic description field is required.',
            'description_ar.string' => 'The Arabic description must be a string.',
            'description_en.required' => 'The English description field is required.',
            'description_en.string' => 'The English description must be a string.',
            'calender_ar.required' => 'The Arabic calendar field is required.',
            'calender_ar.string' => 'The Arabic calendar must be a string.',
            'calender_ar.max' => 'The Arabic calendar may not be greater than 255 characters.',
            'calender_en.required' => 'The English calendar field is required.',
            'calender_en.string' => 'The English calendar must be a string.',
            'calender_en.max' => 'The English calendar may not be greater than 255 characters.',
            'interest_ar.required' => 'The Arabic interest field is required.',
            'interest_ar.string' => 'The Arabic interest must be a string.',
            'interest_ar.max' => 'The Arabic interest may not be greater than 255 characters.',
            'interest_en.required' => 'The English interest field is required.',
            'interest_en.string' => 'The English interest must be a string.',
            'interest_en.max' => 'The English interest may not be greater than 255 characters.',
            'program_type_id.required' => 'The program type field is required.',
            'program_type_id.numeric' => 'The program type must be a number.',
            'program_type_id.min' => 'The program type must be at least 1.',
            'program_type_id.exists' => 'The selected program type is invalid.',
            'value.required' => 'The value field is required.',
            'value.numeric' => 'The value must be a number.',
            'value.min' => 'The value must be at least 0.',
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
