<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\MessageId;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\SuggestedPostParameters;

/**
 * @see https://core.telegram.org/bots/api#copymessage
 *
 * @template-implements MethodInterface<MessageId>
 */
final readonly class CopyMessage implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        private int|string $chatId,
        private int|string $fromChatId,
        private int $messageId,
        private ?int $messageThreadId = null,
        private ?string $caption = null,
        private ?string $parseMode = null,
        private ?array $captionEntities = null,
        private ?bool $showCaptionAboveMedia = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        private ?bool $allowPaidBroadcast = null,
        private ?int $videoStartTimestamp = null,
        private ?int $directMessagesTopicId = null,
        private ?SuggestedPostParameters $suggestedPostParameters = null,
    ) {}


    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'copyMessage';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'from_chat_id' => $this->fromChatId,
                'message_id' => $this->messageId,
                'video_start_timestamp' => $this->videoStartTimestamp,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'allow_paid_broadcast' => $this->allowPaidBroadcast,
                'suggested_post_parameters' => $this->suggestedPostParameters?->toRequestArray(),
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(MessageId::class);
    }
}
