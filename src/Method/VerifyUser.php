<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#verifyuser
 *
 * @template-implements MethodInterface<true>
 */
final readonly class VerifyUser implements MethodInterface
{
    public function __construct(
        private int $userId,
        private ?string $customDescription = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'verifyUser';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'custom_description' => $this->customDescription,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
