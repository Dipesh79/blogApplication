<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApiBaseController extends Controller
{
    /**
     * @param $data
     * @param string $message
     * @return JsonResponse
     */
    public function api_success($data, string $message): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => $message
        ], 200);
    }

    /**
     * @param Exception $data
     * @return JsonResponse
     */
    public function api_error(Exception $data): JsonResponse
    {
        Log::error($data);
        return response()->json([
            'status' => $data->getCode(),
            'data' => [],
            'message' => $data->getMessage()
        ], $data->getCode());
    }

    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */

    public function custom_error($data, string $message, int $code): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
