<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'company_name' => ['string', 'max:255'],
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
        ];
    }
}
