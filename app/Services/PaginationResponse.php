<?php

namespace App\Services;

use App\Http\Resources\UserResourse;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class PaginationResponse {
    public function __construct() {}
    public  function responseWithPagination($paginator): JsonResponse {
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
