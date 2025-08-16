<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\SuggestedPostParameters;

/**
 * @see https://core.telegram.org/bots/api#sendlocation
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class SendLocation implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private float $latitude,
        private float $longitude,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?float $horizontalAccuracy = null,
        private ?int $livePeriod = null,
        private ?int $heading = null,
        private ?int $proximityAlertRadius = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        private ?bool $allowPaidBroadcast = null,
        private ?int $directMessagesTopicId = null,
        private ?SuggestedPostParameters $suggestedPostParameters = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendLocation';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'horizontal_accuracy' => $this->horizontalAccuracy,
                'live_period' => $this->livePeriod,
                'heading' => $this->heading,
                'proximity_alert_radius' => $this->proximityAlertRadius,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'allow_paid_broadcast' => $this->allowPaidBroadcast,
                'message_effect_id' => $this->messageEffectId,
                'suggested_post_parameters' => $this->suggestedPostParameters?->toRequestArray(),
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Message::class);
    }
}
