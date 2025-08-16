<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\InputMediaAudio;
use Vjik\TelegramBot\Api\Type\InputMediaDocument;
use Vjik\TelegramBot\Api\Type\InputMediaPhoto;
use Vjik\TelegramBot\Api\Type\InputMediaVideo;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

/**
 * @see https://core.telegram.org/bots/api#sendmediagroup
 *
 * @template-implements MethodInterface<array<Message>>
 */
final readonly class SendMediaGroup implements MethodInterface
{
    /**
     * @param InputMediaAudio[]|InputMediaDocument[]|InputMediaPhoto[]|InputMediaVideo[] $media
     */
    public function __construct(
        private int|string $chatId,
        private array $media,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private ?bool $allowPaidBroadcast = null,
        private ?int $directMessagesTopicId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendMediaGroup';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $media = array_map(
            static function (
                InputMediaAudio|InputMediaDocument|InputMediaPhoto|InputMediaVideo $inputMedia,
            ) use ($fileCollector): array {
                return $inputMedia->toRequestArray($fileCollector);
            },
            $this->media,
        );

        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'media' => $media,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'allow_paid_broadcast' => $this->allowPaidBroadcast,
                'message_effect_id' => $this->messageEffectId,
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Message::class);
    }
}
