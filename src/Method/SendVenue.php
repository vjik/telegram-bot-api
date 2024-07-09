<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

/**
 * @see https://core.telegram.org/bots/api#sendvenue
 */
final readonly class SendVenue implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private float $latitude,
        private float $longitude,
        private string $title,
        private string $address,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?string $foursquareId = null,
        private ?string $foursquareType = null,
        private ?string $googlePlaceId = null,
        private ?string $googlePlaceType = null,
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
        return 'sendVenue';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'title' => $this->title,
                'address' => $this->address,
                'foursquare_id' => $this->foursquareId,
                'foursquare_type' => $this->foursquareType,
                'google_place_id' => $this->googlePlaceId,
                'google_place_type' => $this->googlePlaceType,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'message_effect_id' => $this->messageEffectId,
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return Message::class;
    }
}
