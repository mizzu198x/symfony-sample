<?php

declare(strict_types=1);

namespace App\Exception\Http;

class BadRequestException extends AbstractContextualException
{
    protected const STATUS_TEXT = 'Bad request';

    protected const STATUS_CODE = 400;
}
