<?php

namespace App\Exceptions;

use App\Builder\ReturnApi;
use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    /** @var int */
    protected $code = 500;

    /** @var string */
    protected $message = 'Erro inesperado';

    public function render(): JsonResponse
    {
        return ReturnApi::error(message: $this->message, status: $this->code);
    }
}