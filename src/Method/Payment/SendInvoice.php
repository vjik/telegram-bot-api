<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Payment;

use SensitiveParameter;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\SuggestedPostParameters;

/**
 * @see https://core.telegram.org/bots/api#sendinvoice
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class SendInvoice implements MethodInterface
{
    /**
     * @param LabeledPrice[] $prices
     * @param int[]|null $suggestedTipAmounts
     */
    public function __construct(
        private int|string $chatId,
        private string $title,
        private string $description,
        private string $payload,
        private string $currency,
        private array $prices,
        private ?int $messageThreadId = null,
        #[SensitiveParameter]
        private ?string $providerToken = null,
        private ?int $maxTipAmount = null,
        private ?array $suggestedTipAmounts = null,
        private ?string $startParameter = null,
        private ?string $providerData = null,
        private ?string $photoUrl = null,
        private ?int $photoSize = null,
        private ?int $photoWidth = null,
        private ?int $photoHeight = null,
        private ?bool $needName = null,
        private ?bool $needPhoneNumber = null,
        private ?bool $needEmail = null,
        private ?bool $needShippingAddress = null,
        private ?bool $sendPhoneNumberToProvider = null,
        private ?bool $sendEmailToProvider = null,
        private ?bool $isFlexible = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
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
        return 'sendInvoice';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'title' => $this->title,
                'description' => $this->description,
                'payload' => $this->payload,
                'provider_token' => $this->providerToken,
                'currency' => $this->currency,
                'prices' => array_map(
                    static fn(LabeledPrice $price) => $price->toRequestArray(),
                    $this->prices,
                ),
                'max_tip_amount' => $this->maxTipAmount,
                'suggested_tip_amounts' => $this->suggestedTipAmounts,
                'start_parameter' => $this->startParameter,
                'provider_data' => $this->providerData,
                'photo_url' => $this->photoUrl,
                'photo_size' => $this->photoSize,
                'photo_width' => $this->photoWidth,
                'photo_height' => $this->photoHeight,
                'need_name' => $this->needName,
                'need_phone_number' => $this->needPhoneNumber,
                'need_email' => $this->needEmail,
                'need_shipping_address' => $this->needShippingAddress,
                'send_phone_number_to_provider' => $this->sendPhoneNumberToProvider,
                'send_email_to_provider' => $this->sendEmailToProvider,
                'is_flexible' => $this->isFlexible,
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
