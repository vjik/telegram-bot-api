<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use DateTimeImmutable;
use JsonException;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Method\Close;
use Vjik\TelegramBot\Api\Method\CopyMessage;
use Vjik\TelegramBot\Api\Method\CopyMessages;
use Vjik\TelegramBot\Api\Method\DeleteMyCommands;
use Vjik\TelegramBot\Api\Method\ForwardMessage;
use Vjik\TelegramBot\Api\Method\ForwardMessages;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Method\GetChatMenuButton;
use Vjik\TelegramBot\Api\Method\GetFile;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\Method\GetMyCommands;
use Vjik\TelegramBot\Api\Method\GetMyDescription;
use Vjik\TelegramBot\Api\Method\GetMyName;
use Vjik\TelegramBot\Api\Method\GetMyShortDescription;
use Vjik\TelegramBot\Api\Method\GetUserProfilePhotos;
use Vjik\TelegramBot\Api\Method\LogOut;
use Vjik\TelegramBot\Api\Method\Payments\GetStarTransactions;
use Vjik\TelegramBot\Api\Method\SendAudio;
use Vjik\TelegramBot\Api\Method\SendChatAction;
use Vjik\TelegramBot\Api\Method\SendContact;
use Vjik\TelegramBot\Api\Method\SendDice;
use Vjik\TelegramBot\Api\Method\SendDocument;
use Vjik\TelegramBot\Api\Method\SendLocation;
use Vjik\TelegramBot\Api\Method\SendMessage;
use Vjik\TelegramBot\Api\Method\SendPhoto;
use Vjik\TelegramBot\Api\Method\SendPoll;
use Vjik\TelegramBot\Api\Method\SendVenue;
use Vjik\TelegramBot\Api\Method\SendVideo;
use Vjik\TelegramBot\Api\Method\SetChatMenuButton;
use Vjik\TelegramBot\Api\Method\SetMyCommands;
use Vjik\TelegramBot\Api\Method\SetMyDescription;
use Vjik\TelegramBot\Api\Method\SetMyName;
use Vjik\TelegramBot\Api\Method\SetMyShortDescription;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScope;
use Vjik\TelegramBot\Api\Type\BotDescription;
use Vjik\TelegramBot\Api\Type\BotName;
use Vjik\TelegramBot\Api\Type\BotShortDescription;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputPollOption;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\MenuButton;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\MessageId;
use Vjik\TelegramBot\Api\Type\Payments\StarTransactions;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\ResponseParameters;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\UserProfilePhotos;
use Vjik\TelegramBot\Api\Method\Update\DeleteWebhook;
use Vjik\TelegramBot\Api\Method\Update\GetUpdates;
use Vjik\TelegramBot\Api\Method\Update\GetWebhookInfo;
use Vjik\TelegramBot\Api\Method\Update\SetWebhook;
use Vjik\TelegramBot\Api\Type\Update\Update;
use Vjik\TelegramBot\Api\Type\Update\WebhookInfo;

final class TelegramBotApi
{
    public function __construct(
        private TelegramClientInterface $telegramClient,
    ) {
    }

    /**
     * @see https://core.telegram.org/bots/api#making-requests
     */
    public function send(TelegramRequestInterface $request): mixed
    {
        $response = $this->telegramClient->send($request);

        try {
            $decodedBody = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidResponseFormatException(
                'Failed to decode JSON response. Status code: ' . $response->statusCode . '.',
                previous: $e
            );
        }

        if (!is_array($decodedBody)) {
            throw new InvalidResponseFormatException(
                'Expected telegram response as array. Got "' . get_debug_type($decodedBody) . '".'
            );
        }

        if (!isset($decodedBody['ok']) || !is_bool($decodedBody['ok'])) {
            throw new InvalidResponseFormatException(
                'Incorrect "ok" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        return $decodedBody['ok']
            ? $this->prepareSuccessResult($request, $response, $decodedBody)
            : $this->prepareFailResult($request, $response, $decodedBody);
    }

    /**
     * @see https://core.telegram.org/bots/api#close
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function close(): FailResult|true
    {
        return $this->send(new Close());
    }

    /**
     * @see https://core.telegram.org/bots/api#copymessage
     *
     * @param MessageEntity[]|null $captionEntities
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function copyMessage(
        int|string $chatId,
        int|string $fromChatId,
        int $messageId,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|MessageId {
        return $this->send(
            new CopyMessage(
                $chatId,
                $fromChatId,
                $messageId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $disableNotification,
                $protectContent,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#copymessages
     *
     * @param int[] $messageIds
     * @return FailResult|MessageId[]
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function copyMessages(
        int|string $chatId,
        int|string $fromChatId,
        array $messageIds,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?bool $removeCaption = null,
    ): FailResult|array {
        return $this->send(
            new CopyMessages(
                $chatId,
                $fromChatId,
                $messageIds,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $removeCaption,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemycommands
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function deleteMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new DeleteMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#forwardmessage
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function forwardMessage(
        int|string $chatId,
        int|string $fromChatId,
        int $messageId,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
    ): FailResult|Message
    {
        return $this->send(
            new ForwardMessage(
                $chatId,
                $fromChatId,
                $messageId,
                $messageThreadId,
                $disableNotification,
                $protectContent,
            )
        );
    }

    /**
     * @param int[] $messageIds
     * @return FailResult|MessageId[]
     *
     * @see https://core.telegram.org/bots/api#forwardmessages
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function forwardMessages(
        int|string $chatId,
        int|string $fromChatId,
        array $messageIds,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
    ): FailResult|array {
        return $this->send(
            new ForwardMessages(
                $chatId,
                $fromChatId,
                $messageIds,
                $messageThreadId,
                $disableNotification,
                $protectContent,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletewebhook
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function deleteWebhook(?bool $dropPendingUpdates = null): FailResult|true
    {
        return $this->send(new DeleteWebhook($dropPendingUpdates));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getChat(int|string $chatId): FailResult|ChatFullInfo
    {
        return $this->send(new GetChat($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmenubutton
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getChatMenuButton(?int $chatId = null): FailResult|MenuButton
    {
        return $this->send(new GetChatMenuButton($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getfile
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getFile(string $fileId): FailResult|File
    {
        return $this->send(new GetFile($fileId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMe(): FailResult|User
    {
        return $this->send(new GetMe());
    }

    /**
     * @see https://core.telegram.org/bots/api#getmycommands
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|array
    {
        return $this->send(new GetMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmydescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyDescription(?string $languageCode = null): FailResult|BotDescription
    {
        return $this->send(new GetMyDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyname
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyName(?string $languageCode = null): FailResult|BotName
    {
        return $this->send(new GetMyName($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyshortdescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyShortDescription(?string $languageCode = null): FailResult|BotShortDescription
    {
        return $this->send(new GetMyShortDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getstartransactions
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getStarTransactions(?int $offset = null, ?int $limit = null): FailResult|StarTransactions
    {
        return $this->send(
            new GetStarTransactions($offset, $limit)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getupdates
     *
     * @param string[]|null $allowedUpdates
     * @return FailResult|Update[]
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getUpdates(
        ?int $offset = null,
        ?int $limit = null,
        ?int $timeout = null,
        ?array $allowedUpdates = null,
    ): FailResult|array {
        return $this->send(new GetUpdates($offset, $limit, $timeout, $allowedUpdates));
    }

    /**
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getUserProfilePhotos(
        int $userId,
        ?int $offset = null,
        ?int $limit = null
    ): FailResult|UserProfilePhotos {
        return $this->send(
            new GetUserProfilePhotos($userId, $offset, $limit)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getWebhookInfo(): FailResult|WebhookInfo
    {
        return $this->send(new GetWebhookInfo());
    }

    /**
     * @see https://core.telegram.org/bots/api#logout
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function logOut(): FailResult|true
    {
        return $this->send(new LogOut());
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendaudio
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendAudio(
        int|string $chatId,
        string|InputFile $audio,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?int $duration = null,
        ?string $performer = null,
        ?string $title = null,
        string|InputFile|null $thumbnail = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message
    {
        return $this->send(
            new SendAudio(
                $chatId,
                $audio,
                $businessConnectionId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $duration,
                $performer,
                $title,
                $thumbnail,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendchataction
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendChatAction(
        int|string $chatId,
        string $action,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
    ): FailResult|true {
        return $this->send(
            new SendChatAction(
                $chatId,
                $action,
                $businessConnectionId,
                $messageThreadId
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendcontact
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendContact(
        int|string $chatId,
        string $phoneNumber,
        string $firstName,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $lastName = null,
        ?string $vcard = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message
    {
        return $this->send(
            new SendContact(
                $chatId,
                $phoneNumber,
                $firstName,
                $businessConnectionId,
                $messageThreadId,
                $lastName,
                $vcard,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#senddice
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendDice(
        int|string $chatId,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $emoji = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendDice(
                $chatId,
                $businessConnectionId,
                $messageThreadId,
                $emoji,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#senddocument
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendDocument(
        int|string $chatId,
        string|InputFile $document,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        string|InputFile|null $thumbnail = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $disableContentTypeDetection = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendDocument(
                $chatId,
                $document,
                $businessConnectionId,
                $messageThreadId,
                $thumbnail,
                $caption,
                $parseMode,
                $captionEntities,
                $disableContentTypeDetection,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendlocation
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendLocation(
        int|string $chatId,
        float $latitude,
        float $longitude,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?float $horizontalAccuracy = null,
        ?int $livePeriod = null,
        ?int $heading = null,
        ?int $proximityAlertRadius = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendLocation(
                $chatId,
                $latitude,
                $longitude,
                $businessConnectionId,
                $messageThreadId,
                $horizontalAccuracy,
                $livePeriod,
                $heading,
                $proximityAlertRadius,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @param MessageEntity[]|null $entities
     *
     * @see https://core.telegram.org/bots/api#sendmessage
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendMessage(
        int|string $chatId,
        string $text,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $parseMode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $linkPreviewOptions = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendMessage(
                $chatId,
                $text,
                $businessConnectionId,
                $messageThreadId,
                $parseMode,
                $entities,
                $linkPreviewOptions,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendphoto
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendPhoto(
        int|string $chatId,
        string|InputFile $photo,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $hasSpoiler = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendPhoto(
                $chatId,
                $photo,
                $businessConnectionId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $hasSpoiler,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @param InputPollOption[] $options
     * @param MessageEntity[]|null $questionEntities
     * @param MessageEntity[]|null $explanationEntities
     *
     * @see https://core.telegram.org/bots/api#sendpoll
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendPoll(
        int|string $chatId,
        string $question,
        array $options,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $questionParseMode = null,
        ?array $questionEntities = null,
        ?bool $isAnonymous = null,
        ?string $type = null,
        ?bool $allowsMultipleAnswers = null,
        ?int $correctOptionId = null,
        ?string $explanation = null,
        ?string $explanationParseMode = null,
        ?array $explanationEntities = null,
        ?int $openPeriod = null,
        ?DateTimeImmutable $closeDate = null,
        ?bool $isClosed = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendPoll(
                $chatId,
                $question,
                $options,
                $businessConnectionId,
                $messageThreadId,
                $questionParseMode,
                $questionEntities,
                $isAnonymous,
                $type,
                $allowsMultipleAnswers,
                $correctOptionId,
                $explanation,
                $explanationParseMode,
                $explanationEntities,
                $openPeriod,
                $closeDate,
                $isClosed,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendvenue
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendVenue(
        int|string $chatId,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $foursquareId = null,
        ?string $foursquareType = null,
        ?string $googlePlaceId = null,
        ?string $googlePlaceType = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendVenue(
                $chatId,
                $latitude,
                $longitude,
                $title,
                $address,
                $businessConnectionId,
                $messageThreadId,
                $foursquareId,
                $foursquareType,
                $googlePlaceId,
                $googlePlaceType,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendvideo
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendVideo(
        int|string $chatId,
        string|InputFile $video,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        string|InputFile|null $thumbnail = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $hasSpoiler = null,
        ?bool $supportsStreaming = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendVideo(
                $chatId,
                $video,
                $businessConnectionId,
                $messageThreadId,
                $duration,
                $width,
                $height,
                $thumbnail,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $hasSpoiler,
                $supportsStreaming,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setChatMenuButton(?int $chatId = null, ?MenuButton $menuButton = null): FailResult|true
    {
        return $this->send(new SetChatMenuButton($chatId, $menuButton));
    }

    /**
     * @param BotCommand[] $commands
     *
     * @see https://core.telegram.org/bots/api#setmycommands
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyCommands(
        array $commands,
        ?BotCommandScope $scope = null,
        ?string $languageCode = null,
    ): FailResult|true {
        return $this->send(new SetMyCommands($commands, $scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmydescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyDescription(?string $description = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new SetMyDescription($description, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyname
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyName(?string $name = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new SetMyName($name, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyshortdescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyShortDescription(
        ?string $shortDescription = null,
        ?string $languageCode = null
    ): FailResult|true {
        return $this->send(new SetMyShortDescription($shortDescription, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setwebhook
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setWebhook(
        string $url,
        ?string $ipAddress = null,
        ?int $maxConnections = null,
        ?array $allowUpdates = null,
        ?bool $dropPendingUpdates = null,
        ?string $secretToken = null,
    ): FailResult|true {
        return $this->send(
            new SetWebhook($url, $ipAddress, $maxConnections, $allowUpdates, $dropPendingUpdates, $secretToken)
        );
    }

    private function prepareSuccessResult(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        array $decodedBody
    ): mixed {
        if (!array_key_exists('result', $decodedBody)) {
            throw new InvalidResponseFormatException(
                'Not found "result" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        return $request instanceof TelegramRequestWithResultPreparingInterface
            ? $request->prepareResult($decodedBody['result'])
            : $decodedBody['result'];
    }

    private function prepareFailResult(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        array $decodedBody
    ): FailResult {
        return new FailResult(
            $request,
            $response,
            (isset($decodedBody['description']) && is_string($decodedBody['description']))
                ? $decodedBody['description']
                : null,
            ResponseParameters::fromDecodedBody($decodedBody),
            $decodedBody['error_code'] ?? null,
        );
    }
}
