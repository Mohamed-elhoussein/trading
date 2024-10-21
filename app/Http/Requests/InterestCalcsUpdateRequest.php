<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InterestCalcsUpdateRequest extends FormRequest
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

            'period_globle_id' => 'required|numeric|unique:interest_calcs,period_globle_id,' . $id,
            'id' => 'required|exists:interest_calcs,id',
            'percent' => 'required|numeric|min:0'

        ];
    }

    public function messages()
    {
        return [
            'period_globle_id.required' => 'The period field is required.',
            'period_globle_id.numeric' => 'The period field must be a number.',
            'period_globle_id.unique' => 'The selected period has already been taken.',
            'id.required' => 'The ID field is required.',
            'id.exists' => 'The selected ID does not exist in the interest calculations.',
            'percent.required' => 'The interest percentage field is required.',
            'percent.numeric' => 'The interest percentage must be a number.',
            'percent.min' => 'The interest percentage must be at least 0.',
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
