# Telegram Bot API for PHP Change Log

## 0.4.0 under development

- New #103: Add `Update::getRaw()` method that returns raw data if type created by `Update::fromJson()` or 
  `Update::fromServerRequest()`.
- New #106: Add logging.
- Chg #105: Remove `InvalidResponseFormatException` in favor `TelegramParseResultException`.

## 0.3.0 July 7, 2024

- New #100: Add `refundedPayment` parameter to `Message` type and add `RefundedPayment` type.
- Chg #99: Add `ResultFactory` and value processors, simplify type and method classes.

## 0.2.1 July 2, 2024

- New #91: Add `TransactionPartnerTelegramAds` type.
- New #92: Add `canSendPaidMedia` parameter to `ChatFullInfo` type.
- New #93: Add `paidMedia` parameter to `Message` and `ExternalReplyInfo` types, add `PaidMediaInfo`,
  `PaidMediaPreview`, `PaidMediaPhoto`, `PaidMediaVideo` types.
- New #94: Add `invoicePayload` parameter to `TransactionPartnerUser` type.
- New #95: Add `sendPaidMedia` method and `InputPaidMediaPhoto`, `InputPaidMediaVideo` types.

## 0.2.0 June 29, 2024

- New #16: Add `sendContact` method.
- New #17: Add `getUserProfilePhotos` method and `UserProfilePhotos` type.
- New #18: Add `sendPoll` method and `InputPollOption` type.
- New #19: Add `sendAudio` method.
- New #20: Add `sendDocument` method.
- New #21: Add `sendVideo` method.
- New #22: Add `getStarTransactions` method and `StarTransactions`, `StarTransaction`, `TransactionPartner`, 
  `RevenueWithdrawalState` types.
- New #23: Add `logOut` and `close` methods.
- New #25: Add `forwardMessage` and `forwardMessages` methods, and `MessageId` type.
- New #26: Add `copyMessage` and `copyMessages` methods.
- New #27: Add `sendAnimation` method.
- New #28: Add `sendVoice` method.
- New #29: Add `sendVideoNote` method.
- New #31: Add `sendMediaGroup` method and `InputMediaAnimation`, `InputMediaAudio`, `InputMediaDocument`,
  `InputMediaPhoto`, `InputMediaVideo` types.
- New #32: Add `setMessageReaction` method and `ReactionType::toRequestArray()` method.
- New #33: Add `banChatMember` and `unbanChatMember` methods.
- New #34: Add `restrictChatMember` method and `ChatPermissions::toRequestArray()` method.
- New #35: Add `promoteChatMember` method.
- New #36: Add `setChatAdministratorCustomTitle` method.
- New #37: Add `banChatSenderChat` and `unbanChatSenderChat` methods.
- New #38: Add `setChatPermissions` method.
- New #39: Add `exportChatInviteLink`, `createChatInviteLink`, `editChatInviteLink` and `revokeChatInviteLink` methods.
- New #40: Add `approveChatJoinRequest` and `declineChatJoinRequest` methods.
- New #42: Add `setChatPhoto` and `deleteChatPhoto` methods.
- New #43: Add `setChatTitle` and `setChatDescription` methods.
- New #44: Add `pinChatMessage`, `unpinChatMessage` and `unpinAllChatMessages` methods.
- New #46: Add `leaveChat` method.
- New #47: Add `getChatAdministrators`, `getChatMemberCount` and `getChatMember` methods.
- New #49: Add `createNewStickerSet` method, `InputSticker` type, `StickerType` and `StickerFormat` classes with
  constants, and `MaskPosition::toRequestArray()` method.
- New #50: Add `deleteStickerSet` method.
- New #51: Add `getStickerSet` method and `StickerSet` type.
- New #52: Add `sendSticker` method.
- New #54: Add `getCustomEmojiStickers` method.
- New #55: Add `uploadStickerFile` method.
- New #57: Add `addStickerToSet`, `deleteStickerFromSet` and `replaceStickerInSet` methods.
- New #58: Add `setStickerPositionInSet`, `setStickerEmojiList`, `setStickerKeywords` and `setStickerMaskPosition`
  methods.
- New #60: Add `setStickerSetTitle` method.
- New #61: Add `setStickerSetThumbnail` method.
- New #62: Add `setCustomEmojiStickerSetThumbnail` method.
- New #63: Add `setChatStickerSet` and `deleteChatStickerSet` methods.
- New #64: Add `getForumTopicIconStickers` method.
- New #65: Add `createForumTopic`, `editForumTopic`, `closeForumTopic`, `reopenForumTopic`, `deleteForumTopic` methods,
  `ForumTopic` type and `ForumTopicIconColor` class with constants.
- New #66: Add `unpinAllForumTopicMessages` and `unpinAllGeneralForumTopicMessages` methods.
- New #67: Add `editGeneralForumTopic`, `closeGeneralForumTopic`, `reopenGeneralForumTopic`, `hideGeneralForumTopic`
  and `unhideGeneralForumTopic` methods.
- New #68: Add `answerCallbackQuery` method.
- New #69: Add `getUserChatBoosts` method and `UserChatBoosts` type.
- New #70: Add `getBusinessConnection` method.
- New #71: Add `getMyDefaultAdministratorRights` and `setMyDefaultAdministratorRights` methods.
- New #72: Add `editMessageText` method and `ParseMode` class with constants.
- New #73: Add `editMessageCaption` method.
- New #74: Add `editMessageMedia` method and `MessageEntityType` class with constants.
- New #75: Add `editMessageLiveLocation` and `stopMessageLiveLocation` methods.
- New #76: Add `editMessageReplyMarkup` method.
- New #77: Add `stopPoll` method.
- New #78: Add `deleteMessage` and `deleteMessages` methods.
- New #79: Add `answerInlineQuery` method, `InlineQueryResultsButton`, `InlineQueryResult*`, `InputMessageContent*` and
  `LabeledPrice` types.
- New #80: Add `answerWebAppQuery` method and `SentWebAppMessage` type.
- New #81: Add `sendInvoice` method.
- New #82: Add `createInvoiceLink` method.
- New #83: Add `answerShippingQuery` and `answerPreCheckoutQuery` methods, and `ShippingOption` type.
- New #84: Add `refundStarPayment` method.
- New #85: Add `setPassportDataErrors` method and `PassportElementError*` types.
- New #86: Add `sendGame` method.
- New #87: Add `setGameScore` method.
- New #88: Add `getGameHighScores` method and `GameHighScore` type.
- Chg #24: Move update methods to `Vjik\TelegramBot\Api\Method\Update` namespace, and update types to
  `Vjik\TelegramBot\Api\Type\Update` namespace.
- Chg #30: Remove `TelegramRequestWithFilesInterface`.
- Chg #59: Change namespaces `Vjik\TelegramBot\Api\Type\Payments` to `Vjik\TelegramBot\Api\Type\Payment`
  and `Vjik\TelegramBot\Api\Method\Payments` to `Vjik\TelegramBot\Api\Method\Payment`.
- Enh #56: Add specific exception on unsuccessfully opening a file in `InputFile::fromLocalFile()`.
- Bug #48: Fix incorrect string values addition to POST request with files in `PsrTelegramClient`.
- Bug #53: Fix incorrect array values addition to GET request in `PsrTelegramClient`.

## 0.1.0 June 10, 2024 

- Initial release.
