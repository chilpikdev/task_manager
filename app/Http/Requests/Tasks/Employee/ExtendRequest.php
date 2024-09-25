<?php

namespace App\Http\Requests\Tasks\Employee;

use App\Http\Requests\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ExtendRequest extends FormRequest
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
            'task_id' => 'required|integer|exists:tasks,id',
            'date_time' => 'required|date|date_format:Y-m-d H:i:s',
        ];
    }
}
