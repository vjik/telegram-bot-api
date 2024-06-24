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
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

/**
 * @see https://core.telegram.org/bots/api#sendvideonote
 */
final readonly class SendVideoNote implements
    TelegramRequestWithResultPreparingInterface,
    TelegramRequestWithFilesInterface
{
    public function __construct(
        private int|string $chatId,
        private string|InputFile $videoNote,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?int $duration = null,
        private ?int $length = null,
        private string|InputFile|null $thumbnail = null,
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
        return 'sendVideoNote';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'video_note' => is_string($this->videoNote) ? $this->videoNote : null,
                'duration' => $this->duration,
                'length' => $this->length,
                'thumbnail' => is_string($this->thumbnail) ? $this->thumbnail : null,
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
                'video_note' => $this->videoNote instanceof InputFile ? $this->videoNote : null,
                'thumbnail' => $this->thumbnail instanceof InputFile ? $this->thumbnail : null,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): Message
    {
        return Message::fromTelegramResult($result);
    }
}
