<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PeroidGlobalUpdateRequest extends FormRequest
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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'num_months' => 'required|numeric|min:1|unique:peroid_globels,num_months,' . $id,
            'id' => 'required|exists:peroid_globels,id'
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
            'num_months.required' => 'The number of months field is required.',
            'num_months.numeric' => 'The number of months must be a number.',
            'num_months.min' => 'The number of months must be at least 1.',
            'num_months.unique' => 'The number of months has already been taken.',
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
