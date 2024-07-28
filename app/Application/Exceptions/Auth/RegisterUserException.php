<?php

namespace App\Exceptions\Auth;

use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Validation\ValidationException;

class RegisterUserException extends Handler
{
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $this->invalidJson($request, $e);
    }

    public function invalidJson($request, ValidationException $e)
    {
        return response()->json([
            'message' => $e->getMessage(),
            'error' => $e->errors(),
        ], $e->status);
    }
}
