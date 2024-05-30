<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#getchat
 */
final readonly class GetMe implements TelegramRequestInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMe';
    }

    public function getData(): array
    {
        return [];
    }

    public function getSuccessCallback(): ?callable
    {
        return static fn(mixed $result) => User::fromTelegramResult($result);
    }
}
