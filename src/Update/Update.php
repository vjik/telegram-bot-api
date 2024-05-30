<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

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
use Vjik\TelegramBot\Api\Type\Payments\PreCheckoutQuery;
use Vjik\TelegramBot\Api\Type\Payments\ShippingQuery;
use Vjik\TelegramBot\Api\Type\Poll;
use Vjik\TelegramBot\Api\Type\PollAnswer;

/**
 * @see https://core.telegram.org/bots/api#update
 */
final readonly class Update
{
    public function __construct(
        public int $updateId,
        public ?Message $message,
        public ?Message $editedMessage,
        public ?Message $channelPost,
        public ?Message $editedChannelPost,
        public ?BusinessConnection $businessConnection,
        public ?Message $businessMessage,
        public ?Message $editedBusinessMessage,
        public ?BusinessMessagesDeleted $deletedBusinessMessages,
        public ?MessageReactionUpdated $messageReaction,
        public ?MessageReactionCountUpdated $messageReactionCount,
        public ?InlineQuery $inlineQuery,
        public ?ChosenInlineResult $chosenInlineResult,
        public ?CallbackQuery $callbackQuery,
        public ?ShippingQuery $shippingQuery,
        public ?PreCheckoutQuery $preCheckoutQuery,
        public ?Poll $poll,
        public ?PollAnswer $pollAnswer,
        public ?ChatMemberUpdated $myChatMember,
        public ?ChatMemberUpdated $chatMember,
        public ?ChatJoinRequest $chatJoinRequest,
        public ?ChatBoostUpdated $chatBoost,
        public ?ChatBoostRemoved $removedChatBoost,
    ) {
    }
}
