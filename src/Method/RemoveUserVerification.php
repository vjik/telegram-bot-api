<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#removeuserverification
 *
 * @template-implements MethodInterface<true>
 */
final readonly class RemoveUserVerification implements MethodInterface
{
    public function __construct(
        private int $userId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'removeUserVerification';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
