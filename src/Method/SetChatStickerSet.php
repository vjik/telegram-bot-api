<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#setchatstickerset
 *
 * @template-implements TelegramRequestInterface<TrueValue>
 */
final readonly class SetChatStickerSet implements TelegramRequestInterface
{
    public function __construct(
        private int|string $chatId,
        private string $stickerSetName,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatStickerSet';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'sticker_set_name' => $this->stickerSetName,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
