<?php

namespace App\Http\Requests\Users;

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
            'name' => 'required|string|min:2|max:255',
            'position' => 'required|string|min:2|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'birthday' => 'required|date|date_format:Y-m-d',
            'phone' => 'required|numeric|unique:users,phone|max_digits:12|min_digits:12',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'active' => 'required|boolean'
        ];
    }
}
