<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickeremojilist
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class SetStickerEmojiList implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param string[] $emojiList
     */
    public function __construct(
        private string $sticker,
        private array $emojiList,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerEmojiList';
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
            'emoji_list' => $this->emojiList,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
