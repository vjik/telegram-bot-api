<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Game;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\Game\GameHighScore;

/**
 * @see https://core.telegram.org/bots/api#getgamehighscores
 *
 * @template-implements MethodInterface<array<GameHighScore>>
 */
final readonly class GetGameHighScores implements MethodInterface
{
    public function __construct(
        private int $userId,
        private ?int $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getGameHighScores';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(GameHighScore::class);
    }
}
