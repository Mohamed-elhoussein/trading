<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class ProgramPeriodUpdateRequest extends FormRequest
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
        $programPeriodId = $this->route('id'); // Assuming the route parameter is named 'id'

        return [
            'period_globel_id' => 'required|numeric|unique:program_periods,period_globel_id,' . $programPeriodId . ',id,program_id,' ,
            'percent' => 'required|numeric|min:0',
            'id' => 'required|exists:program_periods,id'
        ];
    }

    public function messages()
    {
        return [
            'period_globel_id.required' => 'The period field is required.',
            'period_globel_id.numeric' => 'The period field must be a number.',
            'period_globel_id.unique' => 'The combination of period and program must be unique.',
            'percent.required' => 'The interest percentage field is required.',
            'percent.numeric' => 'The interest percentage must be a number.',
            'percent.min' => 'The interest percentage must be at least 0.',
          
            'id.required' => 'The ID field is required.',
            'id.exists' => 'The selected ID does not exist.'
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
