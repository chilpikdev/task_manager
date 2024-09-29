<?php

namespace App\Http\Requests\Tasks\Chief;

use App\Enums\PriorityEnum;
use App\Http\Requests\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    use ValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|string|in:' . collect(PriorityEnum::cases())->implode('value', ','),
            'deadline' => 'required|date|date_format:Y-m-d H:i:s',
            'employees_ids' => 'required|array',
            'employees_ids.*' => 'integer|exists:users,id',
        ];
    }
}
