<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\UpdatingMessage;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#deletemessages
 */
final readonly class DeleteMessages implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        private int|string $chatId,
        private array $messageIds,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteMessages';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_ids' => $this->messageIds,
        ];
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
