<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputPaidMedia;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\SuggestedPostParameters;

/**
 * @see https://core.telegram.org/bots/api#sendpaidmedia
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class SendPaidMedia implements MethodInterface
{
    /**
     * @param InputPaidMedia[] $media
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        private int|string $chatId,
        private int $starCount,
        private array $media,
        private ?string $caption = null,
        private ?string $parseMode = null,
        private ?array $captionEntities = null,
        private ?bool $showCaptionAboveMedia = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        private ?string $businessConnectionId = null,
        private ?string $payload = null,
        private ?bool $allowPaidBroadcast = null,
        private ?int $directMessagesTopicId = null,
        private ?SuggestedPostParameters $suggestedPostParameters = null,
        private ?int $messageThreadId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendPaidMedia';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $media = array_map(
            static function (InputPaidMedia $inputMedia) use ($fileCollector): array {
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
                'star_count' => $this->starCount,
                'media' => $media,
                'payload' => $this->payload,
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
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Message::class);
    }
}
