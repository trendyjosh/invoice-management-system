<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'company_number' => ['string', 'max:255', 'nullable'],
            'address_1' => ['string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
            'city' => ['string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'postcode' => ['string', 'max:255'],
            'phone' => ['string', 'max:255'],
            'bank_name' => ['string', 'max:255'],
            'bank_acc_no' => ['string', 'max:8'],
            'bank_sort_code' => ['string', 'max:6'],
            'status' => ['boolean', 'nullable'],
        ];
    }
}
