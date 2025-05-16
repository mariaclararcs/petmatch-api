<?php

use App\Builder\ReturnApi;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api/index.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(
        function (Middleware $middleware): void {
            $middleware->alias(
                [
                    'auth.api' => JwtMiddleware::class,
                ]
            );
        }
    )
    ->withExceptions(
        function (Exceptions $exceptions): void {

            $exceptions->renderable(
                fn (NotFoundHttpException $e): \Illuminate\Http\JsonResponse => ReturnApi::error('Rota não encontrada.')
            );

            $exceptions->renderable(
                fn (ValidationException $e, $request): \Illuminate\Http\JsonResponse => ReturnApi::error(
                    $e->validator->errors()->first(),
                    $e->validator->errors()->toArray()
                )
            );

            $exceptions->render(
                fn (Throwable $e): \Illuminate\Http\JsonResponse => ReturnApi::error(
                    $e->getMessage() ?? 'Erro inesperado na API.'
                )
            );
        }
    )->create();
