<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#removebusinessaccountprofilephoto
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class RemoveBusinessAccountProfilePhoto implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private ?bool $isPublic = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'removeBusinessAccountProfilePhoto';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'is_public' => $this->isPublic,
            ],
            static fn($value) => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
