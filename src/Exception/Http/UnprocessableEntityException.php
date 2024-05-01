<?php

declare(strict_types=1);

namespace App\Exception\Http;

class UnprocessableEntityException extends AbstractContextualException
{
    protected const STATUS_TEXT = 'Unprocessable entity';

    protected const STATUS_CODE = 422;
}
