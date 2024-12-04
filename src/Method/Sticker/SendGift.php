<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#sendgift
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class SendGift implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        private int $userId,
        private string $giftId,
        private ?string $text = null,
        private ?string $textParseMode = null,
        private ?array $textEntities = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendGift';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'gift_id' => $this->giftId,
                'text' => $this->text,
                'text_parse_mode' => $this->textParseMode,
                'text_entities' => $this->textEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->textEntities,
                    ),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}