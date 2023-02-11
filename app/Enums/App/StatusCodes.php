<?php

namespace App\Enums\App;

use BenSampo\Enum\Enum;

final class StatusCodes extends Enum
{
    public const OPERATION_SUCCEEDED = 200;

    public const OPERATION_FAILED = 400;
    public const AUTHENTICATION_FAILED = 401;
    public const PAYMENT_REQUIRED = 402;
    public const AUTHORIZATION_FAILED = 403;
    public const DATA_NOT_FOUND = 404;
    public const MISSING_PARAMETER = 422;
    public const ALREADY_EXISTS = 430;
    public const INVALID_DATA = 450;

    public const SERVER_ERROR = 500;
}
