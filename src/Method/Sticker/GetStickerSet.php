<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\StickerSet;

/**
 * @see https://core.telegram.org/bots/api#getstickerset
 */
final readonly class GetStickerSet implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getStickerSet';
    }

    public function getData(): array
    {
        return ['name' => $this->name];
    }

    public function prepareResult(mixed $result): StickerSet
    {
        return StickerSet::fromTelegramResult($result);
    }
}
