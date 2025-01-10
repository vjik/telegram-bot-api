<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#logout
 *
 * @template-implements TelegramRequestInterface<TrueValue>
 */
final readonly class LogOut implements TelegramRequestInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'logOut';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
