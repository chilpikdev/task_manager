<?php

namespace App\Http\Requests\Tasks\Chief;

use App\Http\Requests\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class AcceptRequest extends FormRequest
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
            'point' => 'nullable|numeric|between:1,5',
            'text' => 'nullable|string|min:5|max:255',
        ];
    }
}
