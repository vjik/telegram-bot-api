# Telegram Bot API for PHP Change Log

## 0.1.1 under development

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
- Chg #24: Move update methods to `Vjik\TelegramBot\Api\Method\Update` namespace, and update types to
  `Vjik\TelegramBot\Api\Type\Update` namespace.
- Chg #30: Remove `TelegramRequestWithFilesInterface`.
- Enh #56: Add specific exception on unsuccessfully opening a file in `InputFile::fromLocalFile()`.
- Bug #48: Fix incorrect string values addition to POST request with files in `PsrTelegramClient`.
- Bug #53: Fix incorrect array values addition to GET request in `PsrTelegramClient`.

## 0.1.0 June 10, 2024 

- Initial release.
