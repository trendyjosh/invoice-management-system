<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceActionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoices' => ['required', 'array'],
            'invoices.*' => ['exists:App\Models\Invoice,id'],
            'action' => ['required', 'in:paid,outstanding'],
        ];
    }
}
