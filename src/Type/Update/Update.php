<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Update;

use JsonException;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\BusinessConnection;
use Vjik\TelegramBot\Api\Type\BusinessMessagesDeleted;
use Vjik\TelegramBot\Api\Type\CallbackQuery;
use Vjik\TelegramBot\Api\Type\ChatBoostRemoved;
use Vjik\TelegramBot\Api\Type\ChatBoostUpdated;
use Vjik\TelegramBot\Api\Type\ChatJoinRequest;
use Vjik\TelegramBot\Api\Type\ChatMemberUpdated;
use Vjik\TelegramBot\Api\Type\Inline\ChosenInlineResult;
use Vjik\TelegramBot\Api\Type\Inline\InlineQuery;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageReactionCountUpdated;
use Vjik\TelegramBot\Api\Type\MessageReactionUpdated;
use Vjik\TelegramBot\Api\Type\Payment\PreCheckoutQuery;
use Vjik\TelegramBot\Api\Type\Payment\ShippingQuery;
use Vjik\TelegramBot\Api\Type\Poll;
use Vjik\TelegramBot\Api\Type\PollAnswer;

/**
 * @see https://core.telegram.org/bots/api#update
 */
final class Update
{
    private ?array $raw = null;

    public function __construct(
        public readonly int $updateId,
        public readonly ?Message $message = null,
        public readonly ?Message $editedMessage = null,
        public readonly ?Message $channelPost = null,
        public readonly ?Message $editedChannelPost = null,
        public readonly ?BusinessConnection $businessConnection = null,
        public readonly ?Message $businessMessage = null,
        public readonly ?Message $editedBusinessMessage = null,
        public readonly ?BusinessMessagesDeleted $deletedBusinessMessages = null,
        public readonly ?MessageReactionUpdated $messageReaction = null,
        public readonly ?MessageReactionCountUpdated $messageReactionCount = null,
        public readonly ?InlineQuery $inlineQuery = null,
        public readonly ?ChosenInlineResult $chosenInlineResult = null,
        public readonly ?CallbackQuery $callbackQuery = null,
        public readonly ?ShippingQuery $shippingQuery = null,
        public readonly ?PreCheckoutQuery $preCheckoutQuery = null,
        public readonly ?Poll $poll = null,
        public readonly ?PollAnswer $pollAnswer = null,
        public readonly ?ChatMemberUpdated $myChatMember = null,
        public readonly ?ChatMemberUpdated $chatMember = null,
        public readonly ?ChatJoinRequest $chatJoinRequest = null,
        public readonly ?ChatBoostUpdated $chatBoost = null,
        public readonly ?ChatBoostRemoved $removedChatBoost = null,
    ) {
    }

    public function hasRaw(): bool
    {
        return $this->raw !== null;
    }

    public function getRaw(): array
    {
        if ($this->raw === null) {
            throw new LogicException('Raw data is not available.');
        }
        return $this->raw;
    }

    /**
     * @throws TelegramParseResultException
     */
    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        $update = new Update(
            ValueHelper::getInteger($result, 'update_id', $raw),
            array_key_exists('message', $result)
                ? Message::fromTelegramResult($result['message'], $raw)
                : null,
            array_key_exists('edited_message', $result)
                ? Message::fromTelegramResult($result['edited_message'], $raw)
                : null,
            array_key_exists('channel_post', $result)
                ? Message::fromTelegramResult($result['channel_post'], $raw)
                : null,
            array_key_exists('edited_channel_post', $result)
                ? Message::fromTelegramResult($result['edited_channel_post'], $raw)
                : null,
            array_key_exists('business_connection', $result)
                ? BusinessConnection::fromTelegramResult($result['business_connection'], $raw)
                : null,
            array_key_exists('business_message', $result)
                ? Message::fromTelegramResult($result['business_message'], $raw)
                : null,
            array_key_exists('edited_business_message', $result)
                ? Message::fromTelegramResult($result['edited_business_message'], $raw)
                : null,
            array_key_exists('deleted_business_messages', $result)
                ? BusinessMessagesDeleted::fromTelegramResult($result['deleted_business_messages'], $raw)
                : null,
            array_key_exists('message_reaction', $result)
                ? MessageReactionUpdated::fromTelegramResult($result['message_reaction'], $raw)
                : null,
            array_key_exists('message_reaction_count', $result)
                ? MessageReactionCountUpdated::fromTelegramResult($result['message_reaction_count'], $raw)
                : null,
            array_key_exists('inline_query', $result)
                ? InlineQuery::fromTelegramResult($result['inline_query'], $raw)
                : null,
            array_key_exists('chosen_inline_result', $result)
                ? ChosenInlineResult::fromTelegramResult($result['chosen_inline_result'], $raw)
                : null,
            array_key_exists('callback_query', $result)
                ? CallbackQuery::fromTelegramResult($result['callback_query'], $raw)
                : null,
            array_key_exists('shipping_query', $result)
                ? ShippingQuery::fromTelegramResult($result['shipping_query'], $raw)
                : null,
            array_key_exists('pre_checkout_query', $result)
                ? PreCheckoutQuery::fromTelegramResult($result['pre_checkout_query'], $raw)
                : null,
            array_key_exists('poll', $result)
                ? Poll::fromTelegramResult($result['poll'], $raw)
                : null,
            array_key_exists('poll_answer', $result)
                ? PollAnswer::fromTelegramResult($result['poll_answer'], $raw)
                : null,
            array_key_exists('my_chat_member', $result)
                ? ChatMemberUpdated::fromTelegramResult($result['my_chat_member'], $raw)
                : null,
            array_key_exists('chat_member', $result)
                ? ChatMemberUpdated::fromTelegramResult($result['chat_member'], $raw)
                : null,
            array_key_exists('chat_join_request', $result)
                ? ChatJoinRequest::fromTelegramResult($result['chat_join_request'], $raw)
                : null,
            array_key_exists('chat_boost', $result)
                ? ChatBoostUpdated::fromTelegramResult($result['chat_boost'], $raw)
                : null,
            array_key_exists('removed_chat_boost', $result)
                ? ChatBoostRemoved::fromTelegramResult($result['removed_chat_boost'], $raw)
                : null,
        );
        $update->raw = $result;
        return $update;
    }

    /**
     * Create a new `Update` object from JSON string.
     *
     * @throws TelegramParseResultException
     */
    public static function fromJson(string $json): Update
    {
        try {
            $decodedJson = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new TelegramParseResultException('Failed to decode JSON.', previous: $e, raw: $json);
        }

        return self::fromTelegramResult($decodedJson);
    }

    /**
     * Create a new `Update` object from PSR-7 server request.
     *
     * @throws TelegramParseResultException
     */
    public static function fromServerRequest(ServerRequestInterface $request): Update
    {
        return self::fromJson((string) $request->getBody());
    }
}
