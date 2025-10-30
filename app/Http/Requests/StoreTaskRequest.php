<?php

namespace App\Http\Requests;

use App\Enums\Priority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
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
            'title' => [
                'required',
                'min:5',
                'max:255',
                Rule::unique('tasks', 'title')->where('user_id', $this->user()->id)->ignore($this->task?->id),
            ],
            'description' => [
                'required',
                'max:255'
            ],
            'priority' => [
                'required',
                new Enum(Priority::class),
            ],
            'category_ids' => [
                'nullable',
                'distinct',
                'array',
            ],
            'category_ids.*' => [
                Rule::exists('categories', 'id')->where(fn($query) => $query->where('user_id', $this->user()->id)),
            ],
            'datetime' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'parent_task_id' => [
                'nullable',
                Rule::exists('tasks', 'id')->where(
                    fn($query) => $query->where('user_id', $this->user()->id)->whereNot('id', $this->task?->id)
                ),
            ],
        ];
    }
}
