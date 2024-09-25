<?php

namespace App\Http\Requests\Tasks\Employee;

use App\Http\Requests\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'search' => 'nullable|string|min:2',
            'state' => 'required|string|in:active,expired,completed,archived',
            'perpage' => 'nullable|integer',
            'page' => 'nullable|integer',
            'year' => 'nullable|integer|date_format:Y',
            'month' => 'nullable|integer|date_format:m',
        ];
    }
}
