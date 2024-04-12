<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    /**
     * Respond with success message and data.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($message = 'Success', $data = null, $statusCode = 200): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $statusCode);
    }

    /**
     * Respond with error message and optional data.
     *
     * @param  string  $message
     * @param  mixed|null  $data
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message = 'Error', $data = null, $statusCode = 400): JsonResponse
    {
        return response()->json(['error' => $message, 'data' => $data], $statusCode);
    }

    /**
     * Respond with validation error message and errors.
     *
     * @param  string  $message
     * @param  mixed  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondValidationError($message = 'Validation Error', $errors = []): JsonResponse
    {
        return $this->respondError($message, $errors, 422);
    }

    /**
     * Respond with created message and data.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated($message = 'Resource Created', $data = null): JsonResponse
    {
        return $this->respondSuccess($message, $data, 201);
    }

    // Add other common methods as needed
}
