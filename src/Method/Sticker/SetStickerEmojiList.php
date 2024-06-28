<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickeremojilist
 */
final readonly class SetStickerEmojiList implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param string[] $emojiList
     */
    public function __construct(
        private string $sticker,
        private array $emojiList,
    ) {
    }

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

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
