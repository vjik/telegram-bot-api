<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use DateTimeImmutable;
use DateTimeInterface;
use JsonException;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Method\ApproveChatJoinRequest;
use Vjik\TelegramBot\Api\Method\BanChatMember;
use Vjik\TelegramBot\Api\Method\BanChatSenderChat;
use Vjik\TelegramBot\Api\Method\Close;
use Vjik\TelegramBot\Api\Method\CopyMessage;
use Vjik\TelegramBot\Api\Method\CopyMessages;
use Vjik\TelegramBot\Api\Method\CreateChatInviteLink;
use Vjik\TelegramBot\Api\Method\DeclineChatJoinRequest;
use Vjik\TelegramBot\Api\Method\DeleteChatPhoto;
use Vjik\TelegramBot\Api\Method\DeleteMyCommands;
use Vjik\TelegramBot\Api\Method\EditChatInviteLink;
use Vjik\TelegramBot\Api\Method\ExportChatInviteLink;
use Vjik\TelegramBot\Api\Method\ForwardMessage;
use Vjik\TelegramBot\Api\Method\ForwardMessages;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Method\GetChatAdministrators;
use Vjik\TelegramBot\Api\Method\GetChatMember;
use Vjik\TelegramBot\Api\Method\GetChatMemberCount;
use Vjik\TelegramBot\Api\Method\GetChatMenuButton;
use Vjik\TelegramBot\Api\Method\GetFile;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\Method\GetMyCommands;
use Vjik\TelegramBot\Api\Method\GetMyDescription;
use Vjik\TelegramBot\Api\Method\GetMyName;
use Vjik\TelegramBot\Api\Method\GetMyShortDescription;
use Vjik\TelegramBot\Api\Method\GetUserProfilePhotos;
use Vjik\TelegramBot\Api\Method\LeaveChat;
use Vjik\TelegramBot\Api\Method\LogOut;
use Vjik\TelegramBot\Api\Method\Payments\GetStarTransactions;
use Vjik\TelegramBot\Api\Method\PinChatMessage;
use Vjik\TelegramBot\Api\Method\PromoteChatMember;
use Vjik\TelegramBot\Api\Method\RestrictChatMember;
use Vjik\TelegramBot\Api\Method\RevokeChatInviteLink;
use Vjik\TelegramBot\Api\Method\SendAnimation;
use Vjik\TelegramBot\Api\Method\SendAudio;
use Vjik\TelegramBot\Api\Method\SendChatAction;
use Vjik\TelegramBot\Api\Method\SendContact;
use Vjik\TelegramBot\Api\Method\SendDice;
use Vjik\TelegramBot\Api\Method\SendDocument;
use Vjik\TelegramBot\Api\Method\SendLocation;
use Vjik\TelegramBot\Api\Method\SendMediaGroup;
use Vjik\TelegramBot\Api\Method\SendMessage;
use Vjik\TelegramBot\Api\Method\SendPhoto;
use Vjik\TelegramBot\Api\Method\SendPoll;
use Vjik\TelegramBot\Api\Method\SendVenue;
use Vjik\TelegramBot\Api\Method\SendVideo;
use Vjik\TelegramBot\Api\Method\SendVideoNote;
use Vjik\TelegramBot\Api\Method\SendVoice;
use Vjik\TelegramBot\Api\Method\SetChatAdministratorCustomTitle;
use Vjik\TelegramBot\Api\Method\SetChatDescription;
use Vjik\TelegramBot\Api\Method\SetChatMenuButton;
use Vjik\TelegramBot\Api\Method\SetChatPermissions;
use Vjik\TelegramBot\Api\Method\SetChatPhoto;
use Vjik\TelegramBot\Api\Method\SetChatTitle;
use Vjik\TelegramBot\Api\Method\SetMessageReaction;
use Vjik\TelegramBot\Api\Method\SetMyCommands;
use Vjik\TelegramBot\Api\Method\SetMyDescription;
use Vjik\TelegramBot\Api\Method\SetMyName;
use Vjik\TelegramBot\Api\Method\SetMyShortDescription;
use Vjik\TelegramBot\Api\Method\Sticker\CreateNewStickerSet;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerSet;
use Vjik\TelegramBot\Api\Method\Sticker\GetStickerSet;
use Vjik\TelegramBot\Api\Method\Sticker\SendSticker;
use Vjik\TelegramBot\Api\Method\UnbanChatMember;
use Vjik\TelegramBot\Api\Method\UnbanChatSenderChat;
use Vjik\TelegramBot\Api\Method\UnpinAllChatMessages;
use Vjik\TelegramBot\Api\Method\UnpinChatMessage;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScope;
use Vjik\TelegramBot\Api\Type\BotDescription;
use Vjik\TelegramBot\Api\Type\BotName;
use Vjik\TelegramBot\Api\Type\BotShortDescription;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;
use Vjik\TelegramBot\Api\Type\ChatMember;
use Vjik\TelegramBot\Api\Type\ChatPermissions;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaAudio;
use Vjik\TelegramBot\Api\Type\InputMediaDocument;
use Vjik\TelegramBot\Api\Type\InputMediaPhoto;
use Vjik\TelegramBot\Api\Type\InputMediaVideo;
use Vjik\TelegramBot\Api\Type\InputPollOption;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\MenuButton;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\MessageId;
use Vjik\TelegramBot\Api\Type\Payments\StarTransactions;
use Vjik\TelegramBot\Api\Type\ReactionType;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\ResponseParameters;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;
use Vjik\TelegramBot\Api\Type\Sticker\StickerSet;
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
     * @see https://core.telegram.org/bots/api#approvechatjoinrequest
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function approveChatJoinRequest(int|string $chatId, int $userId): FailResult|true
    {
        return $this->send(
            new ApproveChatJoinRequest($chatId, $userId)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#banchatmember
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function banChatMember(
        int|string $chatId,
        int $userId,
        ?DateTimeInterface $untilDate = null,
        ?bool $revokeMessages = null,
    ): FailResult|true {
        return $this->send(
            new BanChatMember($chatId, $userId, $untilDate, $revokeMessages)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function banChatSenderChat(int|string $chatId, int $senderChatId): FailResult|true
    {
        return $this->send(
            new BanChatSenderChat($chatId, $senderChatId),
        );
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
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function createChatInviteLink(
        int|string $chatId,
        ?string $name = null,
        ?DateTimeImmutable $expireDate = null,
        ?int $memberLimit = null,
        ?bool $createsJoinRequest = null,
    ): FailResult|ChatInviteLink {
        return $this->send(
            new CreateChatInviteLink($chatId, $name, $expireDate, $memberLimit, $createsJoinRequest)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param InputSticker[] $stickers
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function createNewStickerSet(
        int $userId,
        string $name,
        string $title,
        array $stickers,
        ?string $stickerType = null,
        ?bool $needsRepainting = null,
    ): FailResult|true {
        return $this->send(
            new CreateNewStickerSet($userId, $name, $title, $stickers, $stickerType, $needsRepainting)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#declinechatjoinrequest
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function declineChatJoinRequest(int|string $chatId, int $userId): FailResult|true
    {
        return $this->send(
            new DeclineChatJoinRequest($chatId, $userId)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletechatphoto
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function deleteChatPhoto(int|string $chatId): FailResult|true
    {
        return $this->send(
            new DeleteChatPhoto($chatId)
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
     * @see https://core.telegram.org/bots/api#deletestickerset
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function deleteStickerSet(string $name): FailResult|true
    {
        return $this->send(new DeleteStickerSet($name));
    }

    /**
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function editChatInviteLink(
        int|string $chatId,
        string $inviteLink,
        ?string $name = null,
        ?DateTimeImmutable $expireDate = null,
        ?int $memberLimit = null,
        ?bool $createsJoinRequest = null,
    ): FailResult|ChatInviteLink {
        return $this->send(
            new EditChatInviteLink($chatId, $inviteLink, $name, $expireDate, $memberLimit, $createsJoinRequest)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function exportChatInviteLink(int|string $chatId): FailResult|string
    {
        return $this->send(
            new ExportChatInviteLink($chatId)
        );
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
    ): FailResult|Message {
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
     * @see https://core.telegram.org/bots/api#getchatadministrators
     *
     * @return FailResult|ChatMember[]
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getChatAdministrators(int|string $chatId): FailResult|array
    {
        return $this->send(new GetChatAdministrators($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmembercount
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getChatMemberCount(int|string $chatId): FailResult|int
    {
        return $this->send(new GetChatMemberCount($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmember
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getChatMember(int|string $chatId, int $userId): FailResult|ChatMember
    {
        return $this->send(new GetChatMember($chatId, $userId));
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
     * @see https://core.telegram.org/bots/api#getstickerset
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getStickerSet(string $name): FailResult|StickerSet
    {
        return $this->send(
            new GetStickerSet($name)
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
     * @see https://core.telegram.org/bots/api#leavechat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function leaveChat(int|string $chatId): FailResult|true
    {
        return $this->send(
            new LeaveChat($chatId)
        );
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
     * @see https://core.telegram.org/bots/api#pinchatmessage
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function pinChatMessage(
        int|string $chatId,
        int $messageId,
        ?bool $disableNotification = null,
    ): FailResult|true {
        return $this->send(
            new PinChatMessage($chatId, $messageId, $disableNotification)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#promotechatmember
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function promoteChatMember(
        int|string $chatId,
        int $userId,
        ?bool $isAnonymous = null,
        ?bool $canManageChat = null,
        ?bool $canDeleteMessages = null,
        ?bool $canManageVideoChats = null,
        ?bool $canRestrictMembers = null,
        ?bool $canPromoteMembers = null,
        ?bool $canChangeInfo = null,
        ?bool $canInviteUsers = null,
        ?bool $canPostStories = null,
        ?bool $canEditStories = null,
        ?bool $canDeleteStories = null,
        ?bool $canPostMessages = null,
        ?bool $canEditMessages = null,
        ?bool $canPinMessages = null,
        ?bool $canManageTopics = null,
    ): FailResult|true {
        return $this->send(
            new PromoteChatMember(
                $chatId,
                $userId,
                $isAnonymous,
                $canManageChat,
                $canDeleteMessages,
                $canManageVideoChats,
                $canRestrictMembers,
                $canPromoteMembers,
                $canChangeInfo,
                $canInviteUsers,
                $canPostStories,
                $canEditStories,
                $canDeleteStories,
                $canPostMessages,
                $canEditMessages,
                $canPinMessages,
                $canManageTopics
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#restrictchatmember
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function restrictChatMember(
        int|string $chatId,
        int $userId,
        ChatPermissions $permissions,
        ?bool $useIndependentChatPermissions = null,
        ?DateTimeImmutable $untilDate = null,
    ): FailResult|true {
        return $this->send(
            new RestrictChatMember($chatId, $userId, $permissions, $useIndependentChatPermissions, $untilDate)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function revokeChatInviteLink(int|string $chatId, string $inviteLink): FailResult|ChatInviteLink
    {
        return $this->send(
            new RevokeChatInviteLink($chatId, $inviteLink)
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendanimation
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendAnimation(
        int|string $chatId,
        InputFile|string $animation,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        InputFile|string|null $thumbnail = null,
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
            new SendAnimation(
                $chatId,
                $animation,
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
    ): FailResult|Message {
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
    ): FailResult|Message {
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
     * @see https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param InputMediaAudio[]|InputMediaDocument[]|InputMediaPhoto[]|InputMediaVideo[] $media
     * @return FailResult|Message[]
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendMediaGroup(
        int|string $chatId,
        array $media,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
    ): FailResult|array {
        return $this->send(
            new SendMediaGroup(
                $chatId,
                $media,
                $businessConnectionId,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
            ),
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
     * @see https://core.telegram.org/bots/api#sendsticker
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendSticker(
        int|string $chatId,
        InputFile|string $sticker,
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
            new SendSticker(
                $chatId,
                $sticker,
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
     * @see https://core.telegram.org/bots/api#sendvideonote
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendVideoNote(
        int|string $chatId,
        string|InputFile $videoNote,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?int $duration = null,
        ?int $length = null,
        string|InputFile|null $thumbnail = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendVideoNote(
                $chatId,
                $videoNote,
                $businessConnectionId,
                $messageThreadId,
                $duration,
                $length,
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
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendvoice
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendVoice(
        int|string $chatId,
        string|InputFile $voice,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?int $duration = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendVoice(
                $chatId,
                $voice,
                $businessConnectionId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $duration,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setChatAdministratorCustomTitle(
        int|string $chatId,
        int $userId,
        string $customTitle
    ): FailResult|true {
        return $this->send(
            new SetChatAdministratorCustomTitle($chatId, $userId, $customTitle)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatdescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setChatDescription(int|string $chatId, ?string $description = null): FailResult|true
    {
        return $this->send(
            new SetChatDescription($chatId, $description)
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
     * @see https://core.telegram.org/bots/api#setchatpermissions
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setChatPermissions(
        int|string $chatId,
        ChatPermissions $permissions,
        ?bool $useIndependentChatPermissions = null,
    ): FailResult|true {
        return $this->send(
            new SetChatPermissions($chatId, $permissions, $useIndependentChatPermissions)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatphoto
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setChatPhoto(int|string $chatId, InputFile $photo): FailResult|true
    {
        return $this->send(
            new SetChatPhoto($chatId, $photo)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchattitle
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setChatTitle(int|string $chatId, string $title): FailResult|true
    {
        return $this->send(
            new SetChatTitle($chatId, $title)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setmessagereaction
     *
     * @param ReactionType[]|null $reaction
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMessageReaction(
        int|string $chatId,
        int $messageId,
        ?array $reaction = null,
        ?bool $isBig = null,
    ): FailResult|true {
        return $this->send(
            new SetMessageReaction($chatId, $messageId, $reaction, $isBig)
        );
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

    /**
     * @see https://core.telegram.org/bots/api#unbanchatmember
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function unbanChatMember(
        int|string $chatId,
        int $userId,
        ?bool $onlyIfBanned = null,
    ): FailResult|true {
        return $this->send(
            new UnbanChatMember($chatId, $userId, $onlyIfBanned)
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function unbanChatSenderChat(int|string $chatId, int $senderChatId): FailResult|true
    {
        return $this->send(
            new UnbanChatSenderChat($chatId, $senderChatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function unpinChatMessage(int|string $chatId, ?int $messageId = null): FailResult|true
    {
        return $this->send(
            new UnpinChatMessage($chatId, $messageId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallchatmessages
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function unpinAllChatMessages(int|string $chatId): FailResult|true
    {
        return $this->send(
            new UnpinAllChatMessages($chatId),
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
