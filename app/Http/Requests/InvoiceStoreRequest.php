<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer' => ['required', 'exists:App\Models\Customer,id'],
            'invoiceItems' => ['required', 'array'],
            'invoiceItems.*' => ['array:description,quantity,unit_price'],
            'invoiceItems.*.description' => ['string'],
            'invoiceItems.*.quantity' => ['integer', 'min:1'],
            'invoiceItems.*.unit_price' => ['decimal:0,2', 'min:0.01'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'invoiceItems.*.*' => 'All fields are required for Item #:position.',
            'invoiceItems.*.*.min' => 'There must be a minimum value entered.',
        ];
    }
}
