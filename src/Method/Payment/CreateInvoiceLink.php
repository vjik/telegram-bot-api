<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\StringValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;

/**
 * @see https://core.telegram.org/bots/api#createinvoicelink
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<StringValue>
 */
final readonly class CreateInvoiceLink implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param LabeledPrice[] $prices
     * @param int[]|null $suggestedTipAmounts
     */
    public function __construct(
        private string $title,
        private string $description,
        private string $payload,
        private string $currency,
        private array $prices,
        private ?string $providerToken = null,
        private ?int $maxTipAmount = null,
        private ?array $suggestedTipAmounts = null,
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
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'createInvoiceLink';
    }

    public function getData(): array
    {
        return array_filter(
            [
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
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): StringValue
    {
        return new StringValue();
    }
}
