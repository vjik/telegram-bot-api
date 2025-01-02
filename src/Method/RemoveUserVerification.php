<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#removeuserverification
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class RemoveUserVerification implements TelegramRequestWithResultPreparingInterface
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
