<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

trait ReturnsApiResponses
{

    private function baseResponse(int $code, string $message = null, mixed $data = null): JsonResponse
    {
        return Response::json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function success(string $message = null, mixed $data = null): JsonResponse
    {
        return $this->baseResponse(ResponseAlias::HTTP_OK, $message, $data);
    }

    public function unauthorized(string $message = null): JsonResponse
    {
        return $this->baseResponse(ResponseAlias::HTTP_UNAUTHORIZED, $message);
    }

    public function error(int $code, string $message = null, mixed $data = null): JsonResponse
    {
        return $this->baseResponse($code, $message, $data);
    }

    public function validatorError(Validator $validator, string $message = null): JsonResponse
    {
        return $this->error(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $message, $validator->errors());
    }

    public function exception(Throwable $exception): JsonResponse
    {
        return $this->baseResponse(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage(), [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }

}
