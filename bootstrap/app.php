<?php

use App\Exceptions\DuplicatedEmailException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\DuplicatedLicenseNumberException;
use App\Exceptions\DuplicatedNationalIdException;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\InvalidRefreshToken;
use App\Exceptions\RefreshTokenNotFound;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\WrongLoginPortalException;
use App\Http\Middleware\InternalServiceMiddleware;
use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['internal' => InternalServiceMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(fn() => true);

        $exceptions->render(function (InvalidCredentialsException $e) {
            return ApiResponse::error('INVALID_CREDENTIALS', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (DuplicatedEmailException $e) {
            return ApiResponse::error('DUPLICATE_EMAIL', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (DuplicatedNationalIdException $e) {
            return ApiResponse::error('DUPLICATE_NATIONAL_ID', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (DuplicatedLicenseNumberException $e) {
            return ApiResponse::error('DUPLICATE_LICENSE_NUMBER', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (WrongLoginPortalException $e) {
            return ApiResponse::error('WRONG_LOGIN_PORTAL', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (InvalidRefreshToken $e) {
            return ApiResponse::error('INVALID_REFRESH_TOKEN', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (RefreshTokenNotFound $e) {
            return ApiResponse::error('REFRESH_TOKEN_NOT_FOUND', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (UserNotFoundException $e) {
            return ApiResponse::error('USER_NOT_FOUND', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (InvalidPasswordException $e) {
            return ApiResponse::error('INVALID_PASSWORD', $e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (ValidationException $e){
            return ApiResponse::validationError($e->errors());
        });

        // $exceptions->render(function (\Throwable $e) {
        //     return ApiResponse::error(
        //         'INTERNAL_SERVER_ERROR',
        //         app()->isProduction() ? 'An unexpected error occurred' : $e->getMessage(),
        //         500
        //     );
        // });

    })->create();
