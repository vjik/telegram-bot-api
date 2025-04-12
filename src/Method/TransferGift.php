<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#transfergift
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class TransferGift implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private string $ownedGiftId,
        private int $newOwnerChatId,
        private ?int $starCount = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'transferGift';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'owned_gift_id' => $this->ownedGiftId,
                'new_owner_chat_id' => $this->newOwnerChatId,
                'star_count' => $this->starCount,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
