<?php

namespace App\Builder;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ReturnApi
{
    public static function success(
        mixed $data = null,
        string $message = '',
        int $status = 200
    ): JsonResponse {
        return response()
            ->json(
                [
                    'error' => false,
                    'message' => $message,
                    'data' => $data,
                ],
                $status
            );
    }

    public static function error(
        string $message = '',
        mixed $data = null,
        int $status = 400
    ): JsonResponse {
        return response()
            ->json(
                [
                    'error' => true,
                    'message' => $message,
                    'data' => $data,
                ],
                $status
            );
    }

    protected function failedValidation(Validator $validator): JsonResponse
    {
        $errors = $validator->errors();

        return ReturnApi::error($errors->first(), $errors->toArray());
    }
}
