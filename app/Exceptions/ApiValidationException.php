<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiValidationException extends Exception
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'status' => 422,
            'errors' => $this->validator->errors(),
        ], 422);
    }
}
