<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickersettitle
 *
 * @template-implements TelegramRequestInterface<TrueValue>
 */
final readonly class SetStickerSetTitle implements TelegramRequestInterface
{
    public function __construct(
        private string $name,
        private string $title,
    ) {}

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
