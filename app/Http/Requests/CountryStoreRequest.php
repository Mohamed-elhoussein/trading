<?php

namespace App\Http\Requests;


use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class CountryStoreRequest extends FormRequest
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
            'iso'=>'required|string|max:255'
        ];
    }


    public function messages()
    {
        return [
            'title_ar.required' => 'The title ar field is required.',
            'title_ar.string' => 'The title ar must be a string.',
            'title_ar.max' => 'The title ar may not be greater than 255 characters.',
            'title_en.required' => 'The title en field is required.',
            'title_en.string' => 'The title en must be a string.',
            'title_en.max' => 'The title en may not be greater than 255 characters.',

            'iso.required' => 'The iso field is required.',
            'iso.string' => 'The iso must be a string.',
            'iso.max' => 'The iso may not be greater than 255 characters.',

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
