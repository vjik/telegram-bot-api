<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickerpositioninset
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class SetStickerPositionInSet implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $sticker,
        private int $position,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerPositionInSet';
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
            'position' => $this->position,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
