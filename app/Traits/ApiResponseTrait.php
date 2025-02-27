<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a success response.
     *
     * @param mixed|null $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success(mixed $data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}
