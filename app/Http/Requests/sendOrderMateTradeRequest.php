<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sendOrderMateTradeRequest extends FormRequest
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
        return [
            'Symbol' => 'required|string',
            'operation' => 'required|string|in:Buy,Sell,BuyStop,SellStop',
            'volume' => 'required|numeric|min:0.1',
            'orderId' => 'required|integer|exists:orders,id',
        ];
    }
}
