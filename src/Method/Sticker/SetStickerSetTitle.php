<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickersettitle
 */
final readonly class SetStickerSetTitle implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $name,
        private string $title,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerSetTitle';
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
