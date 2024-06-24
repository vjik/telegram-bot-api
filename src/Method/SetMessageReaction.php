<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ReactionType;

/**
 * @see https://core.telegram.org/bots/api#setmessagereaction
 */
final readonly class SetMessageReaction implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param ReactionType[]|null $reaction
     */
    public function __construct(
        private int|string $chatId,
        private int $messageId,
        private ?array $reaction = null,
        private ?bool $isBig = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMessageReaction';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'reaction' => $this->reaction === null
                    ? null
                    : array_map(
                        static fn(ReactionType $reactionType) => $reactionType->toRequestArray(),
                        $this->reaction,
                    ),
                'is_big' => $this->isBig,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
