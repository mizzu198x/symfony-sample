<?php

declare(strict_types=1);

namespace App\Exception\Http;

use App\Helper\ContextualTrait;
use Symfony\Sample\ContextualInterface;

class AbstractContextualException extends \Exception implements ContextualInterface
{
    use ContextualTrait;

    /** @var string */
    protected const STATUS_TEXT = 'Internal server error';

    /** @var int */
    protected const STATUS_CODE = 500;

    public function getStatusCode(): int
    {
        return static::STATUS_CODE;
    }

    public function getStatusText(): string
    {
        return static::STATUS_TEXT;
    }
}
