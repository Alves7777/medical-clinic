<?php

namespace App\Core\Services;

use App\Abstracts\ApiResponseInterfaceService;
use Illuminate\Http\JsonResponse;

class ApiResponseService implements ApiResponseInterfaceService
{
    public function success($data = null, $message = null, $code = 201): JsonResponse
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function fail($message = null,  $code = 404): JsonResponse
    {
        return response()->json([
            'status' => 'Fail',
            'message' => $message,
        ], $code);
    }

    public function error($data = null, $message = null,  $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
