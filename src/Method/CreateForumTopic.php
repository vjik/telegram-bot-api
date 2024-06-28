<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ForumTopic;

/**
 * @see https://core.telegram.org/bots/api#createforumtopic
 */
final readonly class CreateForumTopic implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private string $name,
        private ?int $iconColor = null,
        private ?string $iconCustomEmojiId = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'createForumTopic';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'name' => $this->name,
                'icon_color' => $this->iconColor,
                'icon_custom_emoji_id' => $this->iconCustomEmojiId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): ForumTopic
    {
        return ForumTopic::fromTelegramResult($result);
    }
}
