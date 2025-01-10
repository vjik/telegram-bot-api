<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestickerset
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class DeleteStickerSet implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $name,
    ) {}

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

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
