<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Game;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectOrTrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#setgamescore
 */
final readonly class SetGameScore implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int $userId,
        private int $score,
        private ?bool $force = null,
        private ?bool $disableEditMessage = null,
        private ?int $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setGameScore';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'score' => $this->score,
                'force' => $this->force,
                'disable_edit_message' => $this->disableEditMessage,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectOrTrueValue
    {
        return new ObjectOrTrueValue(Message::class);
    }
}
