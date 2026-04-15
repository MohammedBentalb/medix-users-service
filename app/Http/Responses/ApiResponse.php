<?php

namespace App\Http\Responses;

use App\Http\Resources\UserResourse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class ApiResponse {
    public static function success(mixed $data, int $statusCode = 200): JsonResponse{
        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => self::meta(), 
        ], $statusCode);
    }

    public static function meta(): array{
        return [
            'service' => config('app.service_name', 'users-service'),
            'request_id' => request()->header('X-Request-Id', Str::uuid7()),
            'timestamp' => now()->toIso8601String()
        ];
    }

    public static function error(string $code, string $message, int $statusCode, array $details = []): JsonResponse {
        return response()->json([
            'success' => false,
            'errors' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
            ],
            'meta' => self::meta(),
        ], $statusCode);
    }

    public static function validationError(array $errors): JsonResponse {
        $details = collect($errors)->map(fn($messages, $field) => ['field' => $field, 'message' => $messages[0]])->values()->all();
        return self::error('VALIDATION_FAILED', 'The request contains invalid data', 422, $details);
    }

    public static function UsersWithPaginationResponse($paginator): JsonResponse {
        return ApiResponse::success([
            'users' => UserResourse::collection($paginator->items()),
            'pagination' => [
                'total' => $paginator->total(),
                'perPage' => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
            ],
        ]);
    }
}