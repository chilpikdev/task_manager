<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiErrorException extends Exception
{
    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'status' => $this->code,
            'message' => $this->message,
        ], $this->code);
    }
}
