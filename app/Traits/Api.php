<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

Trait Api
{
    private function responseSuccess($data, $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], 200);
    }
    private function responseError($message, $statusCode = 422): JsonResponse
    {
        $defaultMessage = "Oops! Something went wrong.";
        return response()->json([
            'success' => false,
            'message' => $defaultMessage,
            'error' => $message,
        ], $statusCode);
    }
}
