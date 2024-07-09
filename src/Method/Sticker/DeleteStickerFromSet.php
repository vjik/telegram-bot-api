<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestickerfromset
 */
final readonly class DeleteStickerFromSet implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $sticker,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteStickerFromSet';
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
