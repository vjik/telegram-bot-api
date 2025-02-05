<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputPollOption;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

/**
 * @see https://core.telegram.org/bots/api#sendpoll
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class SendPoll implements MethodInterface
{
    /**
     * @param InputPollOption[] $options
     * @param MessageEntity[]|null $questionEntities
     * @param MessageEntity[]|null $explanationEntities
     */
    public function __construct(
        private int|string $chatId,
        private string $question,
        private array $options,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?string $questionParseMode = null,
        private ?array $questionEntities = null,
        private ?bool $isAnonymous = null,
        private ?string $type = null,
        private ?bool $allowsMultipleAnswers = null,
        private ?int $correctOptionId = null,
        private ?string $explanation = null,
        private ?string $explanationParseMode = null,
        private ?array $explanationEntities = null,
        private ?int $openPeriod = null,
        private ?DateTimeImmutable $closeDate = null,
        private ?bool $isClosed = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        private ?bool $allowPaidBroadcast = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendPoll';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'question' => $this->question,
                'question_parse_mode' => $this->questionParseMode,
                'question_entities' => $this->questionEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->questionEntities,
                    ),
                'options' => array_map(
                    static fn(InputPollOption $option) => $option->toRequestArray(),
                    $this->options,
                ),
                'is_anonymous' => $this->isAnonymous,
                'type' => $this->type,
                'allows_multiple_answers' => $this->allowsMultipleAnswers,
                'correct_option_id' => $this->correctOptionId,
                'explanation' => $this->explanation,
                'explanation_parse_mode' => $this->explanationParseMode,
                'explanation_entities' => $this->explanationEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->explanationEntities,
                    ),
                'open_period' => $this->openPeriod,
                'close_date' => $this->closeDate?->getTimestamp(),
                'is_closed' => $this->isClosed,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'allow_paid_broadcast' => $this->allowPaidBroadcast,
                'message_effect_id' => $this->messageEffectId,
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
