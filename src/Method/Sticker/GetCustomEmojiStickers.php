<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#getcustomemojistickers
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<ArrayOfObjectsValue<Sticker>>
 */
final readonly class GetCustomEmojiStickers implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param string[] $customEmojiIds
     */
    public function __construct(
        private array $customEmojiIds,
    ) {}

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

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Sticker::class);
    }
}
