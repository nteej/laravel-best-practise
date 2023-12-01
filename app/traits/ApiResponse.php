<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * Send a success response.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($message, $data = null, $status = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
    protected function apiResponse($data = null, $status = Response::HTTP_OK)
    {
        return response()->json(
            //'success' => true,
            //'message' => $message,
            //'context' => $data,
            $data
        , $status);
    }

    /**
     * Send an error response.
     *
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
