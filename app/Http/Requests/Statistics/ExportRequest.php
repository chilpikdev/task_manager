<?php

namespace App\Http\Requests\Statistics;

use App\Http\Requests\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'year' => 'nullable|integer|date_format:Y',
            'month' => 'nullable|integer|date_format:m',
            'employees_ids' => 'nullable|array',
            'employees_ids.*' => 'integer|exists:users,id',
        ];
    }
}
