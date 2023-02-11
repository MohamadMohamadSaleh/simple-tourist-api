<?php

namespace App\Helper;

use App\Enums\App\StatusCodes;
use Illuminate\Http\Response;

trait ApiResponse
{

    public function operationSucceeded($data = null, string $message = "Operation succeeded.", array $headers = []): Response
    {
        return new Response(['message' => $message, 'data' => $data], StatusCodes::OPERATION_SUCCEEDED, $headers);
    }

    public function operationFailed(string $message = "Operation failed.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::OPERATION_FAILED, $headers);
    }

    public function missingParameter(string $message = "Missing parameter.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::MISSING_PARAMETER, $headers);
    }

    public function dataNotFound(string $message = "Data not found.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::DATA_NOT_FOUND, $headers);
    }

    public function alreadyExists(string $message = "Already exists.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::ALREADY_EXISTS, $headers);
    }

    public function authenticationFailed(string $message = "Unauthenticated.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::AUTHENTICATION_FAILED, $headers);
    }

    public function authorizationFailed(string $message = "Unauthorized.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::AUTHORIZATION_FAILED, $headers);
    }

    public function invalidData(string $message = "Invalid data.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::INVALID_DATA, $headers);
    }

    public function serverError(string $message = "Server error.", array $headers = []): Response
    {
        return new Response(['message' => $message], StatusCodes::SERVER_ERROR, $headers);
    }

}
