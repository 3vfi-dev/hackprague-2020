<?php

namespace App\Http\Requests\API\v1\Receipt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReceiptRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hash' => ['required', 'string', 'size:128'],
            'time' => ['required', 'date'],
            'company' => ['required', 'string', 'size:64', Rule::exists('companies', 'code')],
            'pkp' => ['required_without:fik', 'string', 'size:344', Rule::unique('receipts', 'pkp')],
            'fik' => ['required_without:pkp', 'string', 'size:39', Rule::unique('receipts', 'fik')],
            'bkp' => ['required', 'string', 'size:44', Rule::unique('receipts', 'bkp')],
            'custom_text' => ['nullable', 'string'],
            'products.*.code' => ['required', 'string', 'size:64', Rule::exists('products', 'code')],
            'products.*.vat' => ['required', 'boolean'],
            'products.*.quantity' => ['required', 'integer', 'min:0'],
        ];
    }
}
