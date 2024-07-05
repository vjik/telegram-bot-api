<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Update;

use JsonException;
use Psr\Http\Message\ServerRequestInterface;
use Vjik\TelegramBot\Api\ParseResult\ResultFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
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
final readonly class Update
{
    public function __construct(
        public int $updateId,
        public ?Message $message = null,
        public ?Message $editedMessage = null,
        public ?Message $channelPost = null,
        public ?Message $editedChannelPost = null,
        public ?BusinessConnection $businessConnection = null,
        public ?Message $businessMessage = null,
        public ?Message $editedBusinessMessage = null,
        public ?BusinessMessagesDeleted $deletedBusinessMessages = null,
        public ?MessageReactionUpdated $messageReaction = null,
        public ?MessageReactionCountUpdated $messageReactionCount = null,
        public ?InlineQuery $inlineQuery = null,
        public ?ChosenInlineResult $chosenInlineResult = null,
        public ?CallbackQuery $callbackQuery = null,
        public ?ShippingQuery $shippingQuery = null,
        public ?PreCheckoutQuery $preCheckoutQuery = null,
        public ?Poll $poll = null,
        public ?PollAnswer $pollAnswer = null,
        public ?ChatMemberUpdated $myChatMember = null,
        public ?ChatMemberUpdated $chatMember = null,
        public ?ChatJoinRequest $chatJoinRequest = null,
        public ?ChatBoostUpdated $chatBoost = null,
        public ?ChatBoostRemoved $removedChatBoost = null,
    ) {
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
            throw new TelegramParseResultException('Failed to decode JSON.', previous: $e);
        }

        /** @var Update */
        return (new ResultFactory())->create($decodedJson, self::class);
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
