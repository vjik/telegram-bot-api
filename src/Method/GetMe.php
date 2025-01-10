<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#getchat
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<User>>
 */
final readonly class GetMe implements TelegramRequestWithResultPreparingInterface
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

    public function getResultType(): string
    {
        return User::class;
    }
}
