<?php

namespace App\Http\Requests\Comments;

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
            'task_id' => 'required|integer|exists:tasks,id',
            'text' => 'required|string|min:5|max:255',
            'file' => 'nullable|file|mimes:png,jpg,pdf,xlsx,xls,doc,docx,zip,rar|max:10240',
        ];
    }
}
