<?php

namespace App\Http\Requests;

use App\Enums\Expense;
use App\Enums\Priority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreFinanceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'not_in:0',
            ],
            'type' => [
                'required',
                new Enum(Expense::class)
            ],
            'title' => [
                'nullable',
                'max:20'
            ],
            'description' => [
                'nullable',
                'max:100'
            ]
        ];
    }
}
