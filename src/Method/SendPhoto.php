<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithFilesInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

/**
 * @see https://core.telegram.org/bots/api#sendphoto
 */
final readonly class SendPhoto implements TelegramRequestWithFilesInterface, TelegramRequestWithResultPreparingInterface
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        private int|string $chatId,
        private string|InputFile $photo,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?string $caption = null,
        private ?string $parseMode = null,
        private ?array $captionEntities = null,
        private ?bool $showCaptionAboveMedia = null,
        private ?bool $hasSpoiler = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendPhoto';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'photo' => is_string($this->photo) ? $this->photo : null,
                'business_connection_id' => $this->businessConnectionId,
                'message_thread_id' => $this->messageThreadId,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'has_spoiler' => $this->hasSpoiler,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'message_effect_id' => $this->messageEffectId,
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getFiles(): array
    {
        return array_filter(
            [
                'photo' => $this->photo instanceof InputFile ? $this->photo : null,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): Message
    {
        return Message::fromTelegramResult($result);
    }
}
