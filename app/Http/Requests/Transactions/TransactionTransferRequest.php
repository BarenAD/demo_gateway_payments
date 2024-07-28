<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class TransactionTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_to_id' => 'required|numeric',
            'currency_from_id' => 'required|numeric',
            'currency_to_id' => 'required|numeric',
            'value' => 'required|numeric',
            'datetime' => 'nullable|datetime',
        ];
    }
}
