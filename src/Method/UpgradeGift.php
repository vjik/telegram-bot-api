<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#upgradegift
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class UpgradeGift implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private string $ownedGiftId,
        private ?bool $keepOriginalDetails = null,
        private ?int $starCount = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'upgradeGift';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'owned_gift_id' => $this->ownedGiftId,
                'keep_original_details' => $this->keepOriginalDetails,
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
