<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#transferbusinessaccountstars
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class TransferBusinessAccountStars implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private int $starCount,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'transferBusinessAccountStars';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'star_count' => $this->starCount,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
