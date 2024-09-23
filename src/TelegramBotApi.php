<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use DateTimeImmutable;
use DateTimeInterface;
use JsonException;
use Psr\Log\LoggerInterface;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Method\AnswerCallbackQuery;
use Vjik\TelegramBot\Api\Method\ApproveChatJoinRequest;
use Vjik\TelegramBot\Api\Method\BanChatMember;
use Vjik\TelegramBot\Api\Method\BanChatSenderChat;
use Vjik\TelegramBot\Api\Method\Close;
use Vjik\TelegramBot\Api\Method\CloseForumTopic;
use Vjik\TelegramBot\Api\Method\CloseGeneralForumTopic;
use Vjik\TelegramBot\Api\Method\CopyMessage;
use Vjik\TelegramBot\Api\Method\CopyMessages;
use Vjik\TelegramBot\Api\Method\CreateChatInviteLink;
use Vjik\TelegramBot\Api\Method\CreateChatSubscriptionInviteLink;
use Vjik\TelegramBot\Api\Method\CreateForumTopic;
use Vjik\TelegramBot\Api\Method\DeclineChatJoinRequest;
use Vjik\TelegramBot\Api\Method\DeleteChatPhoto;
use Vjik\TelegramBot\Api\Method\DeleteChatStickerSet;
use Vjik\TelegramBot\Api\Method\DeleteForumTopic;
use Vjik\TelegramBot\Api\Method\DeleteMyCommands;
use Vjik\TelegramBot\Api\Method\EditChatInviteLink;
use Vjik\TelegramBot\Api\Method\EditChatSubscriptionInviteLink;
use Vjik\TelegramBot\Api\Method\EditForumTopic;
use Vjik\TelegramBot\Api\Method\EditGeneralForumTopic;
use Vjik\TelegramBot\Api\Method\ExportChatInviteLink;
use Vjik\TelegramBot\Api\Method\ForwardMessage;
use Vjik\TelegramBot\Api\Method\ForwardMessages;
use Vjik\TelegramBot\Api\Method\Game\GetGameHighScores;
use Vjik\TelegramBot\Api\Method\Game\SendGame;
use Vjik\TelegramBot\Api\Method\Game\SetGameScore;
use Vjik\TelegramBot\Api\Method\GetBusinessConnection;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Method\GetChatAdministrators;
use Vjik\TelegramBot\Api\Method\GetChatMember;
use Vjik\TelegramBot\Api\Method\GetChatMemberCount;
use Vjik\TelegramBot\Api\Method\GetChatMenuButton;
use Vjik\TelegramBot\Api\Method\GetFile;
use Vjik\TelegramBot\Api\Method\GetForumTopicIconStickers;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\Method\GetMyCommands;
use Vjik\TelegramBot\Api\Method\GetMyDefaultAdministratorRights;
use Vjik\TelegramBot\Api\Method\GetMyDescription;
use Vjik\TelegramBot\Api\Method\GetMyName;
use Vjik\TelegramBot\Api\Method\GetMyShortDescription;
use Vjik\TelegramBot\Api\Method\GetUserChatBoosts;
use Vjik\TelegramBot\Api\Method\GetUserProfilePhotos;
use Vjik\TelegramBot\Api\Method\HideGeneralForumTopic;
use Vjik\TelegramBot\Api\Method\Inline\AnswerInlineQuery;
use Vjik\TelegramBot\Api\Method\Inline\AnswerWebAppQuery;
use Vjik\TelegramBot\Api\Method\LeaveChat;
use Vjik\TelegramBot\Api\Method\LogOut;
use Vjik\TelegramBot\Api\Method\Passport\SetPassportDataErrors;
use Vjik\TelegramBot\Api\Method\Payment\AnswerPreCheckoutQuery;
use Vjik\TelegramBot\Api\Method\Payment\AnswerShippingQuery;
use Vjik\TelegramBot\Api\Method\Payment\CreateInvoiceLink;
use Vjik\TelegramBot\Api\Method\Payment\GetStarTransactions;
use Vjik\TelegramBot\Api\Method\Payment\RefundStarPayment;
use Vjik\TelegramBot\Api\Method\Payment\SendInvoice;
use Vjik\TelegramBot\Api\Method\PinChatMessage;
use Vjik\TelegramBot\Api\Method\PromoteChatMember;
use Vjik\TelegramBot\Api\Method\ReopenForumTopic;
use Vjik\TelegramBot\Api\Method\ReopenGeneralForumTopic;
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
use Vjik\TelegramBot\Api\Method\SendPaidMedia;
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
use Vjik\TelegramBot\Api\Method\SetChatStickerSet;
use Vjik\TelegramBot\Api\Method\SetChatTitle;
use Vjik\TelegramBot\Api\Method\SetMessageReaction;
use Vjik\TelegramBot\Api\Method\SetMyCommands;
use Vjik\TelegramBot\Api\Method\SetMyDefaultAdministratorRights;
use Vjik\TelegramBot\Api\Method\SetMyDescription;
use Vjik\TelegramBot\Api\Method\SetMyName;
use Vjik\TelegramBot\Api\Method\SetMyShortDescription;
use Vjik\TelegramBot\Api\Method\Sticker\AddStickerToSet;
use Vjik\TelegramBot\Api\Method\Sticker\CreateNewStickerSet;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerFromSet;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerSet;
use Vjik\TelegramBot\Api\Method\Sticker\GetCustomEmojiStickers;
use Vjik\TelegramBot\Api\Method\Sticker\GetStickerSet;
use Vjik\TelegramBot\Api\Method\Sticker\ReplaceStickerInSet;
use Vjik\TelegramBot\Api\Method\Sticker\SendSticker;
use Vjik\TelegramBot\Api\Method\Sticker\SetCustomEmojiStickerSetThumbnail;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerEmojiList;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerKeywords;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerMaskPosition;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerPositionInSet;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerSetThumbnail;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerSetTitle;
use Vjik\TelegramBot\Api\Method\Sticker\UploadStickerFile;
use Vjik\TelegramBot\Api\Method\UnbanChatMember;
use Vjik\TelegramBot\Api\Method\UnbanChatSenderChat;
use Vjik\TelegramBot\Api\Method\UnhideGeneralForumTopic;
use Vjik\TelegramBot\Api\Method\UnpinAllChatMessages;
use Vjik\TelegramBot\Api\Method\UnpinAllForumTopicMessages;
use Vjik\TelegramBot\Api\Method\UnpinAllGeneralForumTopicMessages;
use Vjik\TelegramBot\Api\Method\UnpinChatMessage;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\DeleteMessage;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\DeleteMessages;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageCaption;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageLiveLocation;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageMedia;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageReplyMarkup;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageText;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\StopMessageLiveLocation;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\StopPoll;
use Vjik\TelegramBot\Api\ParseResult\ResultFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScope;
use Vjik\TelegramBot\Api\Type\BotDescription;
use Vjik\TelegramBot\Api\Type\BotName;
use Vjik\TelegramBot\Api\Type\BotShortDescription;
use Vjik\TelegramBot\Api\Type\BusinessConnection;
use Vjik\TelegramBot\Api\Type\ChatAdministratorRights;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;
use Vjik\TelegramBot\Api\Type\ChatMember;
use Vjik\TelegramBot\Api\Type\ChatPermissions;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\ForumTopic;
use Vjik\TelegramBot\Api\Type\Game\GameHighScore;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResult;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultsButton;
use Vjik\TelegramBot\Api\Type\Inline\SentWebAppMessage;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMedia;
use Vjik\TelegramBot\Api\Type\InputMediaAudio;
use Vjik\TelegramBot\Api\Type\InputMediaDocument;
use Vjik\TelegramBot\Api\Type\InputMediaPhoto;
use Vjik\TelegramBot\Api\Type\InputMediaVideo;
use Vjik\TelegramBot\Api\Type\InputPaidMedia;
use Vjik\TelegramBot\Api\Type\InputPollOption;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\MenuButton;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\MessageId;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementError;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;
use Vjik\TelegramBot\Api\Type\Payment\ShippingOption;
use Vjik\TelegramBot\Api\Type\Payment\StarTransactions;
use Vjik\TelegramBot\Api\Type\Poll;
use Vjik\TelegramBot\Api\Type\ReactionType;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\ResponseParameters;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;
use Vjik\TelegramBot\Api\Type\Sticker\StickerSet;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\UserChatBoosts;
use Vjik\TelegramBot\Api\Type\UserProfilePhotos;
use Vjik\TelegramBot\Api\Method\Update\DeleteWebhook;
use Vjik\TelegramBot\Api\Method\Update\GetUpdates;
use Vjik\TelegramBot\Api\Method\Update\GetWebhookInfo;
use Vjik\TelegramBot\Api\Method\Update\SetWebhook;
use Vjik\TelegramBot\Api\Type\Update\Update;
use Vjik\TelegramBot\Api\Type\Update\WebhookInfo;

use function array_key_exists;
use function is_array;
use function is_bool;
use function is_string;

final class TelegramBotApi
{
    private ResultFactory $resultFactory;

    public function __construct(
        private readonly TelegramClientInterface $telegramClient,
        private ?LoggerInterface $logger = null,
    ) {
        $this->resultFactory = new ResultFactory();
    }

    public function withLogger(?LoggerInterface $logger): self
    {
        $new = clone $this;
        $new->logger = $logger;
        return $new;
    }

    /**
     * @see https://core.telegram.org/bots/api#making-requests
     *
     * @psalm-template TClass as object
     * @psalm-template TValue as mixed
     * @psalm-template TRawResult as mixed
     * @psalm-template TResultDefinition as class-string<TClass>|ValueProcessorInterface<TValue>|null
     * @psalm-template TRequest as TelegramRequestInterface|TelegramRequestWithResultPreparingInterface<TResultDefinition>
     * @psalm-param TRequest $request
     * @psalm-return (
     *      TRequest is TelegramRequestWithResultPreparingInterface<TResultDefinition>
     *      ? (
     *          TResultDefinition is class-string
     *          ? TClass
     *          : (
     *              TResultDefinition is null
     *              ? TRawResult
     *              : TValue
     *            )
     *        )
     *      : TRawResult
     * )|FailResult
     */
    public function send(TelegramRequestInterface $request): mixed
    {
        $this->logger?->info(
            'Send ' . $request->getHttpMethod()->value . '-request "' . $request->getApiMethod() . '".',
            LogType::createSendRequestContext($request),
        );
        $response = $this->telegramClient->send($request);

        try {
            $decodedBody = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $this->logger?->error(
                'Failed to decode JSON from telegram response.',
                LogType::createParseResultErrorContext($response->body),
            );
            throw new TelegramParseResultException(
                'Failed to decode JSON response. Status code: ' . $response->statusCode . '.',
                previous: $e,
            );
        }

        if (!is_array($decodedBody)) {
            $this->logger?->error(
                'Incorrect telegram response.',
                LogType::createParseResultErrorContext($response->body),
            );
            throw new TelegramParseResultException(
                'Expected telegram response as array. Got "' . get_debug_type($decodedBody) . '".',
            );
        }

        /** @psalm-var array{result?:TRawResult, ...} $decodedBody */

        if (!isset($decodedBody['ok']) || !is_bool($decodedBody['ok'])) {
            $this->logger?->error(
                'Incorrect "ok" field in telegram response.',
                LogType::createParseResultErrorContext($response->body),
            );
            throw new TelegramParseResultException(
                'Incorrect "ok" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        if ($decodedBody['ok']) {
            $result = $this->prepareSuccessResult($request, $response, $decodedBody);
            $this->logger?->info(
                'On "' . $request->getApiMethod() . '" request Telegram Bot API returned successful result.',
                LogType::createSuccessResultContext($request, $response, $decodedBody),
            );
        } else {
            $result = $this->prepareFailResult($request, $response, $decodedBody);
            $this->logger?->warning(
                'On "' . $request->getApiMethod() . '" request Telegram Bot API returned fail result.',
                LogType::createFailResultContext($request, $response, $decodedBody),
            );
        }

        return $result;
    }

    /**
     * @see https://core.telegram.org/bots/api#addstickertoset
     */
    public function addStickerToSet(int $userId, string $name, InputSticker $sticker): FailResult|true
    {
        return $this->send(
            new AddStickerToSet($userId, $name, $sticker),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answercallbackquery
     */
    public function answerCallbackQuery(
        string $callbackQueryId,
        ?string $text = null,
        ?bool $showAlert = null,
        ?string $url = null,
        ?int $cacheTime = null,
    ): FailResult|true {
        return $this->send(
            new AnswerCallbackQuery($callbackQueryId, $text, $showAlert, $url, $cacheTime),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answerinlinequery
     *
     * @param InlineQueryResult[] $results
     */
    public function answerInlineQuery(
        string $inlineQueryId,
        array $results,
        ?int $cacheTime = null,
        ?bool $isPersonal = null,
        ?string $nextOffset = null,
        ?InlineQueryResultsButton $button = null,
    ): FailResult|true {
        return $this->send(
            new AnswerInlineQuery($inlineQueryId, $results, $cacheTime, $isPersonal, $nextOffset, $button),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answerprecheckoutquery
     */
    public function answerPreCheckoutQuery(
        string $preCheckoutQueryId,
        bool $ok,
        ?string $errorMessage = null,
    ): FailResult|true {
        return $this->send(
            new AnswerPreCheckoutQuery($preCheckoutQueryId, $ok, $errorMessage),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answershippingquery
     *
     * @param ShippingOption[]|null $shippingOptions
     */
    public function answerShippingQuery(
        string $shippingQueryId,
        bool $ok,
        ?array $shippingOptions = null,
        ?string $errorMessage = null,
    ): FailResult|true {
        return $this->send(
            new AnswerShippingQuery($shippingQueryId, $ok, $shippingOptions, $errorMessage),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answerwebappquery
     */
    public function answerWebAppQuery(string $webAppQueryId, InlineQueryResult $result): FailResult|SentWebAppMessage
    {
        return $this->send(
            new AnswerWebAppQuery($webAppQueryId, $result),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#approvechatjoinrequest
     */
    public function approveChatJoinRequest(int|string $chatId, int $userId): FailResult|true
    {
        return $this->send(
            new ApproveChatJoinRequest($chatId, $userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#banchatmember
     */
    public function banChatMember(
        int|string $chatId,
        int $userId,
        ?DateTimeInterface $untilDate = null,
        ?bool $revokeMessages = null,
    ): FailResult|true {
        return $this->send(
            new BanChatMember($chatId, $userId, $untilDate, $revokeMessages),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     */
    public function banChatSenderChat(int|string $chatId, int $senderChatId): FailResult|true
    {
        return $this->send(
            new BanChatSenderChat($chatId, $senderChatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#close
     */
    public function close(): FailResult|true
    {
        return $this->send(new Close());
    }

    /**
     * @see https://core.telegram.org/bots/api#closeforumtopic
     */
    public function closeForumTopic(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->send(new CloseForumTopic($chatId, $messageThreadId));
    }

    /**
     * @see https://core.telegram.org/bots/api#closegeneralforumtopic
     */
    public function closeGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->send(new CloseGeneralForumTopic($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#copymessage
     *
     * @param MessageEntity[]|null $captionEntities
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#copymessages
     *
     * @param int[] $messageIds
     * @return FailResult|MessageId[]
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     */
    public function createChatInviteLink(
        int|string $chatId,
        ?string $name = null,
        ?DateTimeImmutable $expireDate = null,
        ?int $memberLimit = null,
        ?bool $createsJoinRequest = null,
    ): FailResult|ChatInviteLink {
        return $this->send(
            new CreateChatInviteLink($chatId, $name, $expireDate, $memberLimit, $createsJoinRequest),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createchatsubscriptioninvitelink
     */
    public function createChatSubscriptionInviteLink(
        int|string $chatId,
        int $subscriptionPeriod,
        int $subscriptionPrice,
        ?string $name = null,
    ): FailResult|ChatInviteLink {
        return $this->send(
            new CreateChatSubscriptionInviteLink($chatId, $subscriptionPeriod, $subscriptionPrice, $name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createforumtopic
     */
    public function createForumTopic(
        int|string $chatId,
        string $name,
        ?int $iconColor = null,
        ?string $iconCustomEmojiId = null,
    ): FailResult|ForumTopic {
        return $this->send(
            new CreateForumTopic($chatId, $name, $iconColor, $iconCustomEmojiId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createinvoicelink
     *
     * @param LabeledPrice[] $prices
     * @param int[]|null $suggestedTipAmounts
     */
    public function createInvoiceLink(
        string $title,
        string $description,
        string $payload,
        string $currency,
        array $prices,
        ?string $providerToken = null,
        ?int $maxTipAmount = null,
        ?array $suggestedTipAmounts = null,
        ?string $providerData = null,
        ?string $photoUrl = null,
        ?int $photoSize = null,
        ?int $photoWidth = null,
        ?int $photoHeight = null,
        ?bool $needName = null,
        ?bool $needPhoneNumber = null,
        ?bool $needEmail = null,
        ?bool $needShippingAddress = null,
        ?bool $sendPhoneNumberToProvider = null,
        ?bool $sendEmailToProvider = null,
        ?bool $isFlexible = null,
    ): FailResult|string {
        return $this->send(
            new CreateInvoiceLink(
                $title,
                $description,
                $payload,
                $currency,
                $prices,
                $providerToken,
                $maxTipAmount,
                $suggestedTipAmounts,
                $providerData,
                $photoUrl,
                $photoSize,
                $photoWidth,
                $photoHeight,
                $needName,
                $needPhoneNumber,
                $needEmail,
                $needShippingAddress,
                $sendPhoneNumberToProvider,
                $sendEmailToProvider,
                $isFlexible,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param InputSticker[] $stickers
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
            new CreateNewStickerSet($userId, $name, $title, $stickers, $stickerType, $needsRepainting),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#declinechatjoinrequest
     */
    public function declineChatJoinRequest(int|string $chatId, int $userId): FailResult|true
    {
        return $this->send(
            new DeclineChatJoinRequest($chatId, $userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletechatphoto
     */
    public function deleteChatPhoto(int|string $chatId): FailResult|true
    {
        return $this->send(
            new DeleteChatPhoto($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletechatstickerset
     */
    public function deleteChatStickerSet(int|string $chatId): FailResult|true
    {
        return $this->send(
            new DeleteChatStickerSet($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deleteforumtopic
     */
    public function deleteForumTopic(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->send(new DeleteForumTopic($chatId, $messageThreadId));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemessage
     */
    public function deleteMessage(int|string $chatId, int $messageId): FailResult|true
    {
        return $this->send(new DeleteMessage($chatId, $messageId));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemessages
     *
     * @param int[] $messageIds
     */
    public function deleteMessages(int|string $chatId, array $messageIds): FailResult|true
    {
        return $this->send(new DeleteMessages($chatId, $messageIds));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemycommands
     */
    public function deleteMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new DeleteMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     */
    public function deleteStickerFromSet(string $sticker): FailResult|true
    {
        return $this->send(
            new DeleteStickerFromSet($sticker),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletestickerset
     */
    public function deleteStickerSet(string $name): FailResult|true
    {
        return $this->send(new DeleteStickerSet($name));
    }

    /**
     * @see https://core.telegram.org/bots/api#editchatinvitelink
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
            new EditChatInviteLink($chatId, $inviteLink, $name, $expireDate, $memberLimit, $createsJoinRequest),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editchatsubscriptioninvitelink
     */
    public function editChatSubscriptionInviteLink(
        int|string $chatId,
        string $inviteLink,
        ?string $name = null,
    ): FailResult|ChatInviteLink {
        return $this->send(
            new EditChatSubscriptionInviteLink($chatId, $inviteLink, $name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editforumtopic
     */
    public function editForumTopic(
        int|string $chatId,
        int $messageThreadId,
        ?string $name = null,
        ?string $iconCustomEmojiId = null,
    ): FailResult|true {
        return $this->send(
            new EditForumTopic($chatId, $messageThreadId, $name, $iconCustomEmojiId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editgeneralforumtopic
     */
    public function editGeneralForumTopic(int|string $chatId, string $name): FailResult|true
    {
        return $this->send(
            new EditGeneralForumTopic($chatId, $name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param MessageEntity[]|null $captionEntities
     */
    public function editMessageCaption(
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->send(
            new EditMessageCaption(
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     */
    public function editMessageLiveLocation(
        float $latitude,
        float $longitude,
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?int $livePeriod = null,
        ?float $horizontalAccuracy = null,
        ?int $heading = null,
        ?int $proximityAlertRadius = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->send(
            new EditMessageLiveLocation(
                $latitude,
                $longitude,
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $livePeriod,
                $horizontalAccuracy,
                $heading,
                $proximityAlertRadius,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagemedia
     */
    public function editMessageMedia(
        InputMedia $media,
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->send(
            new EditMessageMedia(
                $media,
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     */
    public function editMessageReplyMarkup(
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->send(
            new EditMessageReplyMarkup(
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagetext
     *
     * @param MessageEntity[]|null $entities
     */
    public function editMessageText(
        string $text,
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?string $parseMode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $linkPreviewOptions = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->send(
            new EditMessageText(
                $text,
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $parseMode,
                $entities,
                $linkPreviewOptions,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     */
    public function exportChatInviteLink(int|string $chatId): FailResult|string
    {
        return $this->send(
            new ExportChatInviteLink($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#forwardmessage
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
            ),
        );
    }

    /**
     * @param int[] $messageIds
     * @return FailResult|MessageId[]
     *
     * @see https://core.telegram.org/bots/api#forwardmessages
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletewebhook
     */
    public function deleteWebhook(?bool $dropPendingUpdates = null): FailResult|true
    {
        return $this->send(new DeleteWebhook($dropPendingUpdates));
    }

    /**
     * @see https://core.telegram.org/bots/api#getbusinessconnection
     */
    public function getBusinessConnection(string $businessConnectionId): FailResult|BusinessConnection
    {
        return $this->send(new GetBusinessConnection($businessConnectionId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     */
    public function getChat(int|string $chatId): FailResult|ChatFullInfo
    {
        return $this->send(new GetChat($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatadministrators
     *
     * @return FailResult|ChatMember[]
     */
    public function getChatAdministrators(int|string $chatId): FailResult|array
    {
        return $this->send(new GetChatAdministrators($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmembercount
     */
    public function getChatMemberCount(int|string $chatId): FailResult|int
    {
        return $this->send(new GetChatMemberCount($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmember
     */
    public function getChatMember(int|string $chatId, int $userId): FailResult|ChatMember
    {
        return $this->send(new GetChatMember($chatId, $userId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmenubutton
     */
    public function getChatMenuButton(?int $chatId = null): FailResult|MenuButton
    {
        return $this->send(new GetChatMenuButton($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getcustomemojistickers
     *
     * @param string[] $customEmojiIds
     * @return FailResult|Sticker[]
     */
    public function getCustomEmojiStickers(array $customEmojiIds): FailResult|array
    {
        return $this->send(new GetCustomEmojiStickers($customEmojiIds));
    }

    /**
     * @see https://core.telegram.org/bots/api#getfile
     */
    public function getFile(string $fileId): FailResult|File
    {
        return $this->send(new GetFile($fileId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getforumtopiciconstickers
     *
     * @return FailResult|Sticker[]
     */
    public function getForumTopicIconStickers(): FailResult|array
    {
        return $this->send(new GetForumTopicIconStickers());
    }

    /**
     * @see https://core.telegram.org/bots/api#getgamehighscores
     *
     * @return FailResult|GameHighScore[]
     */
    public function getGameHighScores(
        int $userId,
        ?int $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
    ): FailResult|array {
        return $this->send(
            new GetGameHighScores($userId, $chatId, $messageId, $inlineMessageId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     */
    public function getMe(): FailResult|User
    {
        return $this->send(new GetMe());
    }

    /**
     * @see https://core.telegram.org/bots/api#getmycommands
     */
    public function getMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|array
    {
        return $this->send(new GetMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
     */
    public function getMyDefaultAdministratorRights(?bool $forChannels = null): FailResult|ChatAdministratorRights
    {
        return $this->send(new GetMyDefaultAdministratorRights($forChannels));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmydescription
     */
    public function getMyDescription(?string $languageCode = null): FailResult|BotDescription
    {
        return $this->send(new GetMyDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyname
     */
    public function getMyName(?string $languageCode = null): FailResult|BotName
    {
        return $this->send(new GetMyName($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyshortdescription
     */
    public function getMyShortDescription(?string $languageCode = null): FailResult|BotShortDescription
    {
        return $this->send(new GetMyShortDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getstartransactions
     */
    public function getStarTransactions(?int $offset = null, ?int $limit = null): FailResult|StarTransactions
    {
        return $this->send(
            new GetStarTransactions($offset, $limit),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getstickerset
     */
    public function getStickerSet(string $name): FailResult|StickerSet
    {
        return $this->send(
            new GetStickerSet($name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getupdates
     *
     * @param string[]|null $allowedUpdates
     * @return FailResult|Update[]
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
     * @see https://core.telegram.org/bots/api#getuserchatboosts
     */
    public function getUserChatBoosts(int|string $chatId, int $userId): FailResult|UserChatBoosts
    {
        return $this->send(
            new GetUserChatBoosts($chatId, $userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
     */
    public function getUserProfilePhotos(
        int $userId,
        ?int $offset = null,
        ?int $limit = null,
    ): FailResult|UserProfilePhotos {
        return $this->send(
            new GetUserProfilePhotos($userId, $offset, $limit),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getwebhookinfo
     */
    public function getWebhookInfo(): FailResult|WebhookInfo
    {
        return $this->send(new GetWebhookInfo());
    }

    /**
     * @see https://core.telegram.org/bots/api#hidegeneralforumtopic
     */
    public function hideGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->send(
            new HideGeneralForumTopic($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#leavechat
     */
    public function leaveChat(int|string $chatId): FailResult|true
    {
        return $this->send(
            new LeaveChat($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#logout
     */
    public function logOut(): FailResult|true
    {
        return $this->send(new LogOut());
    }

    /**
     * @see https://core.telegram.org/bots/api#pinchatmessage
     */
    public function pinChatMessage(
        int|string $chatId,
        int $messageId,
        ?bool $disableNotification = null,
    ): FailResult|true {
        return $this->send(
            new PinChatMessage($chatId, $messageId, $disableNotification),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#promotechatmember
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
                $canManageTopics,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#refundstarpayment
     */
    public function refundStarPayment(int $userId, string $telegramPaymentChargeId): FailResult|true
    {
        return $this->send(
            new RefundStarPayment($userId, $telegramPaymentChargeId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#reopenforumtopic
     */
    public function reopenForumTopic(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->send(
            new ReopenForumTopic($chatId, $messageThreadId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#reopengeneralforumtopic
     */
    public function reopenGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->send(
            new ReopenGeneralForumTopic($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#replacestickerinset
     */
    public function replaceStickerInSet(
        int $userId,
        string $name,
        string $oldSticker,
        InputSticker $sticker,
    ): FailResult|true {
        return $this->send(
            new ReplaceStickerInSet($userId, $name, $oldSticker, $sticker),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#restrictchatmember
     */
    public function restrictChatMember(
        int|string $chatId,
        int $userId,
        ChatPermissions $permissions,
        ?bool $useIndependentChatPermissions = null,
        ?DateTimeImmutable $untilDate = null,
    ): FailResult|true {
        return $this->send(
            new RestrictChatMember($chatId, $userId, $permissions, $useIndependentChatPermissions, $untilDate),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     */
    public function revokeChatInviteLink(int|string $chatId, string $inviteLink): FailResult|ChatInviteLink
    {
        return $this->send(
            new RevokeChatInviteLink($chatId, $inviteLink),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendanimation
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
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendaudio
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendchataction
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
                $messageThreadId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendcontact
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#senddice
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
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#senddocument
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendgame
     */
    public function sendGame(
        int $chatId,
        string $gameShortName,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendGame(
                $chatId,
                $gameShortName,
                $businessConnectionId,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendinvoice
     *
     * @param LabeledPrice[] $prices
     * @param int[]|null $suggestedTipAmounts
     */
    public function sendInvoice(
        int|string $chatId,
        string $title,
        string $description,
        string $payload,
        string $currency,
        array $prices,
        ?int $messageThreadId = null,
        ?string $providerToken = null,
        ?int $maxTipAmount = null,
        ?array $suggestedTipAmounts = null,
        ?string $startParameter = null,
        ?string $providerData = null,
        ?string $photoUrl = null,
        ?int $photoSize = null,
        ?int $photoWidth = null,
        ?int $photoHeight = null,
        ?bool $needName = null,
        ?bool $needPhoneNumber = null,
        ?bool $needEmail = null,
        ?bool $needShippingAddress = null,
        ?bool $sendPhoneNumberToProvider = null,
        ?bool $sendEmailToProvider = null,
        ?bool $isFlexible = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendInvoice(
                $chatId,
                $title,
                $description,
                $payload,
                $currency,
                $prices,
                $messageThreadId,
                $providerToken,
                $maxTipAmount,
                $suggestedTipAmounts,
                $startParameter,
                $providerData,
                $photoUrl,
                $photoSize,
                $photoWidth,
                $photoHeight,
                $needName,
                $needPhoneNumber,
                $needEmail,
                $needShippingAddress,
                $sendPhoneNumberToProvider,
                $sendEmailToProvider,
                $isFlexible,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendlocation
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param InputMediaAudio[]|InputMediaDocument[]|InputMediaPhoto[]|InputMediaVideo[] $media
     * @return FailResult|Message[]
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendpaidmedia
     *
     * @param InputPaidMedia[] $media
     * @param MessageEntity[]|null $captionEntities
     */
    public function sendPaidMedia(
        int|string $chatId,
        int $starCount,
        array $media,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?string $businessConnectionId = null,
        ?string $payload = null,
    ): FailResult|Message {
        return $this->send(
            new SendPaidMedia(
                $chatId,
                $starCount,
                $media,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $disableNotification,
                $protectContent,
                $replyParameters,
                $replyMarkup,
                $businessConnectionId,
                $payload,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendphoto
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
            ),
        );
    }

    /**
     * @param InputPollOption[] $options
     * @param MessageEntity[]|null $questionEntities
     * @param MessageEntity[]|null $explanationEntities
     *
     * @see https://core.telegram.org/bots/api#sendpoll
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendsticker
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendvenue
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
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendvideo
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendvideonote
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
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendvoice
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
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     */
    public function setChatAdministratorCustomTitle(
        int|string $chatId,
        int $userId,
        string $customTitle,
    ): FailResult|true {
        return $this->send(
            new SetChatAdministratorCustomTitle($chatId, $userId, $customTitle),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatdescription
     */
    public function setChatDescription(int|string $chatId, ?string $description = null): FailResult|true
    {
        return $this->send(
            new SetChatDescription($chatId, $description),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     */
    public function setChatMenuButton(?int $chatId = null, ?MenuButton $menuButton = null): FailResult|true
    {
        return $this->send(new SetChatMenuButton($chatId, $menuButton));
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatpermissions
     */
    public function setChatPermissions(
        int|string $chatId,
        ChatPermissions $permissions,
        ?bool $useIndependentChatPermissions = null,
    ): FailResult|true {
        return $this->send(
            new SetChatPermissions($chatId, $permissions, $useIndependentChatPermissions),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatphoto
     */
    public function setChatPhoto(int|string $chatId, InputFile $photo): FailResult|true
    {
        return $this->send(
            new SetChatPhoto($chatId, $photo),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatstickerset
     */
    public function setChatStickerSet(int|string $chatId, string $stickerSetName): FailResult|true
    {
        return $this->send(
            new SetChatStickerSet($chatId, $stickerSetName),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchattitle
     */
    public function setChatTitle(int|string $chatId, string $title): FailResult|true
    {
        return $this->send(
            new SetChatTitle($chatId, $title),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setcustomemojistickersetthumbnail
     */
    public function setCustomEmojiStickerSetThumbnail(string $name, ?string $customEmojiId = null): FailResult|true
    {
        return $this->send(new SetCustomEmojiStickerSetThumbnail($name, $customEmojiId));
    }

    /**
     * @see https://core.telegram.org/bots/api#setgamescore
     */
    public function setGameScore(
        int $userId,
        int $score,
        ?bool $force = null,
        ?bool $disableEditMessage = null,
        ?int $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
    ): FailResult|Message|true {
        return $this->send(
            new SetGameScore(
                $userId,
                $score,
                $force,
                $disableEditMessage,
                $chatId,
                $messageId,
                $inlineMessageId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setmessagereaction
     *
     * @param ReactionType[]|null $reaction
     */
    public function setMessageReaction(
        int|string $chatId,
        int $messageId,
        ?array $reaction = null,
        ?bool $isBig = null,
    ): FailResult|true {
        return $this->send(
            new SetMessageReaction($chatId, $messageId, $reaction, $isBig),
        );
    }

    /**
     * @param BotCommand[] $commands
     *
     * @see https://core.telegram.org/bots/api#setmycommands
     */
    public function setMyCommands(
        array $commands,
        ?BotCommandScope $scope = null,
        ?string $languageCode = null,
    ): FailResult|true {
        return $this->send(new SetMyCommands($commands, $scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
     */
    public function setMyDefaultAdministratorRights(
        ?ChatAdministratorRights $rights = null,
        ?bool $forChannels = null,
    ): FailResult|true {
        return $this->send(new SetMyDefaultAdministratorRights($rights, $forChannels));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmydescription
     */
    public function setMyDescription(?string $description = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new SetMyDescription($description, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyname
     */
    public function setMyName(?string $name = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new SetMyName($name, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyshortdescription
     */
    public function setMyShortDescription(
        ?string $shortDescription = null,
        ?string $languageCode = null,
    ): FailResult|true {
        return $this->send(new SetMyShortDescription($shortDescription, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param PassportElementError[] $errors
     */
    public function setPassportDataErrors(int $userId, array $errors): FailResult|true
    {
        return $this->send(new SetPassportDataErrors($userId, $errors));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickeremojilist
     *
     * @param string[] $emojiList
     */
    public function setStickerEmojiList(string $sticker, array $emojiList): FailResult|true
    {
        return $this->send(new SetStickerEmojiList($sticker, $emojiList));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickerkeywords
     *
     * @param string[]|null $keywords
     */
    public function setStickerKeywords(string $sticker, ?array $keywords = null): FailResult|true
    {
        return $this->send(new SetStickerKeywords($sticker, $keywords));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickermaskposition
     */
    public function setStickerMaskPosition(string $sticker, ?MaskPosition $maskPosition = null): FailResult|true
    {
        return $this->send(new SetStickerMaskPosition($sticker, $maskPosition));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     */
    public function setStickerPositionInSet(string $sticker, int $position): FailResult|true
    {
        return $this->send(new SetStickerPositionInSet($sticker, $position));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickersetthumbnail
     */
    public function setStickerSetThumbnail(
        string $name,
        int $userId,
        string $format,
        InputFile|string|null $thumbnail = null,
    ): FailResult|true {
        return $this->send(
            new SetStickerSetThumbnail(
                $name,
                $userId,
                $format,
                $thumbnail,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickersettitle
     */
    public function setStickerSetTitle(string $name, string $title): FailResult|true
    {
        return $this->send(new SetStickerSetTitle($name, $title));
    }

    /**
     * @see https://core.telegram.org/bots/api#setwebhook
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
            new SetWebhook($url, $ipAddress, $maxConnections, $allowUpdates, $dropPendingUpdates, $secretToken),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#stopmessagelivelocation
     */
    public function stopMessageLiveLocation(
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->send(
            new StopMessageLiveLocation(
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#stoppoll
     */
    public function stopPoll(
        int|string $chatId,
        int $messageId,
        ?string $businessConnectionId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Poll {
        return $this->send(
            new StopPoll(
                $chatId,
                $messageId,
                $businessConnectionId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unbanchatmember
     */
    public function unbanChatMember(
        int|string $chatId,
        int $userId,
        ?bool $onlyIfBanned = null,
    ): FailResult|true {
        return $this->send(
            new UnbanChatMember($chatId, $userId, $onlyIfBanned),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     */
    public function unbanChatSenderChat(int|string $chatId, int $senderChatId): FailResult|true
    {
        return $this->send(
            new UnbanChatSenderChat($chatId, $senderChatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unhidegeneralforumtopic
     */
    public function unhideGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->send(
            new UnhideGeneralForumTopic($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     */
    public function unpinChatMessage(int|string $chatId, ?int $messageId = null): FailResult|true
    {
        return $this->send(
            new UnpinChatMessage($chatId, $messageId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallchatmessages
     */
    public function unpinAllChatMessages(int|string $chatId): FailResult|true
    {
        return $this->send(
            new UnpinAllChatMessages($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallforumtopicmessages
     */
    public function unpinAllForumTopicMessages(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->send(
            new UnpinAllForumTopicMessages($chatId, $messageThreadId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallgeneralforumtopicmessages
     */
    public function unpinAllGeneralForumTopicMessages(int|string $chatId): FailResult|true
    {
        return $this->send(
            new UnpinAllGeneralForumTopicMessages($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     */
    public function uploadStickerFile(int $userId, InputFile $sticker, string $stickerFormat): FailResult|File
    {
        return $this->send(
            new UploadStickerFile($userId, $sticker, $stickerFormat),
        );
    }

    /**
     * @psalm-template TClass as object
     * @psalm-template TValue as mixed
     * @psalm-template TRawResult as mixed
     * @psalm-template TResultDefinition as class-string<TClass>|ValueProcessorInterface<TValue>|null
     * @psalm-template TRequest as TelegramRequestInterface|TelegramRequestWithResultPreparingInterface<TResultDefinition>
     * @psalm-param TRequest $request
     * @psalm-param array{result?:TRawResult, ...} $decodedBody
     * @psalm-return (
     *      TRequest is TelegramRequestWithResultPreparingInterface
     *      ? (
     *          TResultDefinition is class-string
     *          ? TClass
     *          : (
     *              TResultDefinition is null
     *              ? TRawResult
     *              : TValue
     *            )
     *        )
     *      : TRawResult
     * )
     */
    private function prepareSuccessResult(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        array $decodedBody,
    ): mixed {
        if (!array_key_exists('result', $decodedBody)) {
            $this->logger?->error(
                'Not found "result" field in telegram response.',
                LogType::createParseResultErrorContext($response->body),
            );
            throw new TelegramParseResultException(
                'Not found "result" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        if (!$request instanceof TelegramRequestWithResultPreparingInterface) {
            return $decodedBody['result'];
        }

        $resultType = $request->getResultType();
        if ($resultType === null) {
            return $decodedBody['result'];
        }

        try {
            return $this->resultFactory->create($decodedBody['result'], $resultType);
        } catch (TelegramParseResultException $exception) {
            $this->logger?->error(
                'Failed to parse telegram result. ' . $exception->getMessage(),
                LogType::createParseResultErrorContext($response->body),
            );
            throw $exception;
        }
    }

    private function prepareFailResult(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        array $decodedBody,
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
