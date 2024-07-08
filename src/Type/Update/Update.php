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
final class Update
{
    private ?string $raw = null;
    private ?array $rawDecoded = null;

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

    public function getRaw(bool $decoded = false): array|string|null
    {
        return $decoded ? $this->rawDecoded : $this->raw;
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

        /** @var Update $update */
        $update = (new ResultFactory())->create($decodedJson, self::class);
        $update->raw = $json;
        $update->rawDecoded = $decodedJson;
        return $update;
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
