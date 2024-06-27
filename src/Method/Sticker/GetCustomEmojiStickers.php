<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#getcustomemojistickers
 */
final readonly class GetCustomEmojiStickers implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param string[] $customEmojiIds
     */
    public function __construct(
        private array $customEmojiIds,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getCustomEmojiStickers';
    }

    public function getData(): array
    {
        return [
            'custom_emoji_ids' => $this->customEmojiIds,
        ];
    }

    /**
     * @return Sticker[]
     */
    public function prepareResult(mixed $result): array
    {
        ValueHelper::assertArrayResult($result);
        return ValueHelper::getArrayOfStickers($result);
    }
}
