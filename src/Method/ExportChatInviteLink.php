<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\StringValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#exportchatinvitelink
 *
 * @template-implements TelegramRequestInterface<StringValue>
 */
final readonly class ExportChatInviteLink implements TelegramRequestInterface
{
    public function __construct(
        private int|string $chatId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'exportChatInviteLink';
    }

    public function getData(): array
    {
        return ['chat_id' => $this->chatId];
    }

    public function getResultType(): StringValue
    {
        return new StringValue();
    }
}
