<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'invoiceItems.*.description' => ['required_with:invoiceItems.*.quantity,invoiceItems.*.unit_price', 'string'],
            'invoiceItems.*.quantity' => ['required_with:invoiceItems.*.description,invoiceItems.*.unit_price', 'integer', 'min:1'],
            'invoiceItems.*.unit_price' => ['required_with:invoiceItems.*.quantity,invoiceItems.*.description', 'decimal:0,2', 'min:0.01'],
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
            'invoiceItems.*.*.required_with' => 'All fields are required for Item #:position.',
            'invoiceItems.*.*.min' => 'There must be a minimum value entered.',
        ];
    }
}
