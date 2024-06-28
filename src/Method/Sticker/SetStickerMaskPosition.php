<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;

/**
 * @see https://core.telegram.org/bots/api#setstickermaskposition
 */
final readonly class SetStickerMaskPosition implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $sticker,
        private ?MaskPosition $maskPosition = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerMaskPosition';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'sticker' => $this->sticker,
                'mask_position' => $this->maskPosition?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
