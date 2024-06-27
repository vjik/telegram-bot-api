<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestickerset
 */
final readonly class DeleteStickerSet implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteStickerSet';
    }

    public function getData(): array
    {
        return ['name' => $this->name];
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
