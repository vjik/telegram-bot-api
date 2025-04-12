<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\ExternalReplyInfo;
use Vjik\TelegramBot\Api\Type\ForumTopicClosed;
use Vjik\TelegramBot\Api\Type\ForumTopicReopened;
use Vjik\TelegramBot\Api\Type\GeneralForumTopicHidden;
use Vjik\TelegramBot\Api\Type\GeneralForumTopicUnhidden;
use Vjik\TelegramBot\Api\Type\GiveawayCreated;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageOriginHiddenUser;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\Payment\RefundedPayment;
use Vjik\TelegramBot\Api\Type\VideoChatStarted;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class MessageTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $chat = new Chat(1, 'private');
        $message = new Message(7, $date, $chat);

        assertSame(7, $message->messageId);
        assertSame($date, $message->date);
        assertSame($chat, $message->chat);
        assertNull($message->messageThreadId);
        assertNull($message->from);
        assertNull($message->senderChat);
        assertNull($message->senderBoostCount);
        assertNull($message->senderBusinessBot);
        assertNull($message->businessConnectionId);
        assertNull($message->forwardOrigin);
        assertNull($message->isTopicMessage);
        assertNull($message->isAutomaticForward);
        assertNull($message->replyToMessage);
        assertNull($message->externalReply);
        assertNull($message->quote);
        assertNull($message->replyToStory);
        assertNull($message->viaBot);
        assertNull($message->editDate);
        assertNull($message->hasProtectedContent);
        assertNull($message->isFromOffline);
        assertNull($message->mediaGroupId);
        assertNull($message->authorSignature);
        assertNull($message->text);
        assertNull($message->entities);
        assertNull($message->linkPreviewOptions);
        assertNull($message->effectId);
        assertNull($message->animation);
        assertNull($message->audio);
        assertNull($message->document);
        assertNull($message->photo);
        assertNull($message->sticker);
        assertNull($message->story);
        assertNull($message->video);
        assertNull($message->videoNote);
        assertNull($message->voice);
        assertNull($message->caption);
        assertNull($message->captionEntities);
        assertNull($message->showCaptionAboveMedia);
        assertNull($message->hasMediaSpoiler);
        assertNull($message->contact);
        assertNull($message->dice);
        assertNull($message->game);
        assertNull($message->poll);
        assertNull($message->venue);
        assertNull($message->location);
        assertNull($message->newChatMembers);
        assertNull($message->leftChatMember);
        assertNull($message->newChatTitle);
        assertNull($message->newChatPhoto);
        assertNull($message->deleteChatPhoto);
        assertNull($message->groupChatCreated);
        assertNull($message->supergroupChatCreated);
        assertNull($message->channelChatCreated);
        assertNull($message->messageAutoDeleteTimerChanged);
        assertNull($message->migrateToChatId);
        assertNull($message->migrateFromChatId);
        assertNull($message->pinnedMessage);
        assertNull($message->invoice);
        assertNull($message->successfulPayment);
        assertNull($message->usersShared);
        assertNull($message->chatShared);
        assertNull($message->gift);
        assertNull($message->uniqueGift);
        assertNull($message->connectedWebsite);
        assertNull($message->writeAccessAllowed);
        assertNull($message->passportData);
        assertNull($message->proximityAlertTriggered);
        assertNull($message->boostAdded);
        assertNull($message->chatBackgroundSet);
        assertNull($message->forumTopicCreated);
        assertNull($message->forumTopicEdited);
        assertNull($message->forumTopicClosed);
        assertNull($message->forumTopicReopened);
        assertNull($message->generalForumTopicHidden);
        assertNull($message->generalForumTopicUnhidden);
        assertNull($message->giveawayCreated);
        assertNull($message->giveaway);
        assertNull($message->giveawayWinners);
        assertNull($message->giveawayCompleted);
        assertNull($message->videoChatScheduled);
        assertNull($message->videoChatStarted);
        assertNull($message->videoChatEnded);
        assertNull($message->videoChatParticipantsInvited);
        assertNull($message->webAppData);
        assertNull($message->replyMarkup);
        assertNull($message->refundedPayment);
    }

    public function testFromTelegramResult(): void
    {
        $message = (new ObjectFactory())->create([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_thread_id' => 3,
            'from' => [
                'id' => 7,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'sender_chat' => [
                'id' => 9,
                'type' => 'private',
            ],
            'sender_boost_count' => 11,
            'sender_business_bot' => [
                'id' => 15,
                'is_bot' => true,
                'first_name' => 'JohnBot',
            ],
            'business_connection_id' => 'btest',
            'forward_origin' => [
                'type' => 'hidden_user',
                'date' => 1234156479,
                'sender_user_name' => 'bat',
            ],
            'is_topic_message' => true,
            'is_automatic_forward' => true,
            'reply_to_message' => [
                'message_id' => 17,
                'date' => 1620000001,
                'chat' => [
                    'id' => 2,
                    'type' => 'private',
                ],
            ],
            'external_reply' => [
                'origin' => [
                    'type' => 'hidden_user',
                    'date' => 1234156480,
                    'sender_user_name' => 'cat',
                ],
            ],
            'quote' => [
                'text' => 'test93',
                'position' => 34,
            ],
            'reply_to_story' => [
                'chat' => [
                    'id' => 32,
                    'type' => 'private',
                ],
                'id' => 8863,
            ],
            'via_bot' => [
                'id' => 127,
                'is_bot' => false,
                'first_name' => 'John6Bot',
            ],
            'edit_date' => 65416841123,
            'has_protected_content' => true,
            'is_from_offline' => true,
            'media_group_id' => 'mg34613',
            'author_signature' => 'as235',
            'text' => 'Hello, World!',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 53,
                ],
            ],
            'link_preview_options' => [
                'url' => 'https://example.com/lpo',
            ],
            'effect_id' => 'e235',
            'animation' => [
                'file_id' => 'an1',
                'file_unique_id' => 'fu1',
                'width' => 320,
                'height' => 240,
                'duration' => 15,
            ],
            'audio' => [
                'file_id' => 'f2',
                'file_unique_id' => 'fu2',
                'duration' => 15,
            ],
            'document' => [
                'file_id' => 'f3',
                'file_unique_id' => 'fu3',
            ],
            'photo' => [
                [
                    'file_id' => 'f4',
                    'file_unique_id' => 'fu4',
                    'width' => 320,
                    'height' => 240,
                ],
            ],
            'sticker' => [
                'file_id' => 'f5',
                'file_unique_id' => 'fu5',
                'type' => 'regular',
                'width' => 320,
                'height' => 240,
                'is_animated' => true,
                'is_video' => false,
            ],
            'story' => [
                'chat' => [
                    'id' => 45,
                    'type' => 'private',
                ],
                'id' => 99,
            ],
            'video' => [
                'file_id' => 'f6',
                'file_unique_id' => 'fu6',
                'width' => 320,
                'height' => 240,
                'duration' => 15,
            ],
            'video_note' => [
                'file_id' => 'f7',
                'file_unique_id' => 'fu7',
                'length' => 5,
                'duration' => 15,
            ],
            'voice' => [
                'file_id' => 'f8',
                'file_unique_id' => 'fu8',
                'duration' => 15,
            ],
            'caption' => 'Hello!',
            'caption_entities' => [
                [
                    'type' => 'bold',
                    'offset' => 0,
                    'length' => 124,
                ],
            ],
            'show_caption_above_media' => true,
            'has_media_spoiler' => true,
            'contact' => [
                'phone_number' => '+1234567890',
                'first_name' => 'Vjik',
            ],
            'dice' => [
                'emoji' => '🎲',
                'value' => 6,
            ],
            'game' => [
                'title' => 'Game',
                'description' => 'Description',
                'photo' => [],
            ],
            'poll' => [
                'id' => 'pid2354',
                'question' => 'Question',
                'options' => [],
                'total_voter_count' => 5,
                'is_closed' => true,
                'is_anonymous' => false,
                'type' => 'regular',
                'allows_multiple_answers' => true,
            ],
            'venue' => [
                'location' => [
                    'latitude' => 55.7558,
                    'longitude' => 37.6176,
                ],
                'title' => 'Venue1',
                'address' => 'Address',
            ],
            'location' => [
                'latitude' => 55.7558,
                'longitude' => 37.6176,
            ],
            'new_chat_members' => [
                [
                    'id' => 798,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
            ],
            'left_chat_member' => [
                'id' => 799,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'new_chat_title' => 'My Chat!',
            'new_chat_photo' => [
                [
                    'file_id' => 'newp1',
                    'file_unique_id' => 'newpu1',
                    'width' => 320,
                    'height' => 240,
                ],
            ],
            'delete_chat_photo' => true,
            'group_chat_created' => true,
            'supergroup_chat_created' => true,
            'channel_chat_created' => true,
            'message_auto_delete_timer_changed' => [
                'message_auto_delete_time' => 91,
            ],
            'migrate_to_chat_id' => 341,
            'migrate_from_chat_id' => 182,
            'pinned_message' => [
                'message_id' => 439,
                'date' => 1620000002,
                'chat' => [
                    'id' => 3,
                    'type' => 'private',
                ],
            ],
            'invoice' => [
                'title' => 'Invoice',
                'description' => 'Description',
                'start_parameter' => 'start',
                'currency' => 'USD',
                'total_amount' => 101,
            ],
            'successful_payment' => [
                'currency' => 'USD',
                'total_amount' => 111,
                'invoice_payload' => 'payload',
                'telegram_payment_charge_id' => '12732',
                'provider_payment_charge_id' => '12733',
            ],
            'users_shared' => [
                'request_id' => 12722,
                'users' => [],
            ],
            'chat_shared' => [
                'request_id' => 364,
                'chat_id' => 2,
            ],
            'gift' => [
                'gift' => [
                    'id' => 'test-id1',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'regular',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'star_count' => 11,
                ],
            ],
            'unique_gift' => [
                'gift' => [
                    'base_name' => 'BaseName',
                    'name' => 'uniqueName',
                    'number' => 1,
                    'model' => [
                        'name' => 'test1',
                        'sticker' => [
                            'file_id' => 'x1',
                            'file_unique_id' => 'fullX1',
                            'type' => 'unique',
                            'width' => 100,
                            'height' => 120,
                            'is_animated' => false,
                            'is_video' => true,
                        ],
                        'rarity_per_mille' => 200,
                    ],
                    'symbol' => [
                        'name' => 'test2',
                        'sticker' => [
                            'file_id' => 'x1',
                            'file_unique_id' => 'fullX1',
                            'type' => 'unique',
                            'width' => 100,
                            'height' => 120,
                            'is_animated' => false,
                            'is_video' => true,
                        ],
                        'rarity_per_mille' => 200,
                    ],
                    'backdrop' => [
                        'name' => 'test3',
                        'colors' => [
                            'center_color' => 1,
                            'edge_color' => 2,
                            'symbol_color' => 3,
                            'text_color' => 4,
                        ],
                        'rarity_per_mille' => 200,
                    ],
                ],
                'origin' => 'transfer',
                'owned_gift_id' => 'owned-id1',
                'transfer_star_count' => 15,
            ],
            'connected_website' => 'example.com',
            'write_access_allowed' => [
                'web_app_name' => 'uqn',
            ],
            'passport_data' => [
                'data' => [],
                'credentials' => [
                    'data' => '',
                    'hash' => 'asdg23GWEH',
                    'secret' => '23gaeh34',
                ],
            ],
            'proximity_alert_triggered' => [
                'traveler' => [
                    'id' => 7128,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'watcher' => [
                    'id' => 321,
                    'is_bot' => false,
                    'first_name' => 'Jane',
                ],
                'distance' => 100,
            ],
            'boost_added' => [
                'boost_count' => 555,
            ],
            'chat_background_set' => [
                'type' => [
                    'type' => 'chat_theme',
                    'theme_name' => 'dark',
                ],
            ],
            'forum_topic_created' => [
                'name' => 'CreateName',
                'icon_color' => 0x002200,
            ],
            'forum_topic_edited' => [
                'name' => 'EditName',
            ],
            'forum_topic_closed' => [],
            'forum_topic_reopened' => [],
            'general_forum_topic_hidden' => [],
            'general_forum_topic_unhidden' => [],
            'giveaway_created' => [],
            'giveaway' => [
                'chats' => [],
                'winners_selection_date' => 1620000000,
                'winner_count' => 2981,
            ],
            'giveaway_winners' => [
                'chat' => [
                    'id' => 4677,
                    'type' => 'private',
                ],
                'giveaway_message_id' => 3461,
                'winners_selection_date' => 1620000002,
                'winner_count' => 0,
                'winners' => [],
            ],
            'giveaway_completed' => [
                'winner_count' => 1679,
            ],
            'video_chat_scheduled' => [
                'start_date' => 1620000012,
            ],
            'video_chat_started' => [],
            'video_chat_ended' => [
                'duration' => 313,
            ],
            'video_chat_participants_invited' => [
                'users' => [
                    [
                        'id' => 17313,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            'web_app_data' => [
                'data' => 'important',
                'button_text' => 'start',
            ],
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Button1241',
                            'url' => 'https://example.com',
                        ],
                    ],
                ],
            ],
            'paid_media' => [
                'star_count' => 1,
                'paid_media' => [
                    [
                        'type' => 'photo',
                        'photo' => [],
                    ],
                ],
            ],
            'refunded_payment' => [
                'currency' => 'XTR',
                'total_amount' => 12,
                'invoice_payload' => 'ip',
                'telegram_payment_charge_id' => 'tpid',
            ],
        ], null, Message::class);

        assertSame(7, $message->messageId);
        assertSame(1620000000, $message->date->getTimestamp());
        assertSame(1, $message->chat->id);
        assertSame(3, $message->messageThreadId);
        assertSame(7, $message->from?->id);
        assertSame(9, $message->senderChat?->id);
        assertSame(11, $message->senderBoostCount);
        assertSame(15, $message->senderBusinessBot?->id);
        assertSame('btest', $message->businessConnectionId);

        assertInstanceOf(MessageOriginHiddenUser::class, $message->forwardOrigin);
        assertSame('bat', $message->forwardOrigin?->senderUserName);

        assertTrue($message->isTopicMessage);
        assertTrue($message->isAutomaticForward);
        assertSame(17, $message->replyToMessage?->messageId);

        assertInstanceOf(ExternalReplyInfo::class, $message->externalReply);
        assertSame('cat', $message->externalReply->origin?->senderUserName);

        assertSame('test93', $message->quote?->text);
        assertSame(8863, $message->replyToStory?->id);
        assertSame(127, $message->viaBot?->id);
        assertSame(65416841123, $message->editDate?->getTimestamp());
        assertTrue($message->hasProtectedContent);
        assertTrue($message->isFromOffline);
        assertSame('mg34613', $message->mediaGroupId);
        assertSame('as235', $message->authorSignature);
        assertSame('Hello, World!', $message->text);

        assertCount(1, $message->entities);
        assertSame(53, $message->entities[0]->length);

        assertSame('https://example.com/lpo', $message->linkPreviewOptions?->url);
        assertSame('e235', $message->effectId);
        assertSame('an1', $message->animation?->fileId);
        assertSame('f2', $message->audio?->fileId);
        assertSame('f3', $message->document?->fileId);

        assertCount(1, $message->photo);
        assertSame('f4', $message->photo[0]->fileId);

        assertSame('f5', $message->sticker?->fileId);
        assertSame(99, $message->story?->id);
        assertSame('f6', $message->video?->fileId);
        assertSame('f7', $message->videoNote?->fileId);
        assertSame('f8', $message->voice?->fileId);
        assertSame('Hello!', $message->caption);

        assertCount(1, $message->captionEntities);
        assertSame(124, $message->captionEntities[0]->length);

        assertTrue($message->showCaptionAboveMedia);
        assertTrue($message->hasMediaSpoiler);
        assertSame('+1234567890', $message->contact?->phoneNumber);
        assertSame('🎲', $message->dice?->emoji);
        assertSame('Game', $message->game?->title);
        assertSame('pid2354', $message->poll?->id);
        assertSame('Venue1', $message->venue?->title);
        assertSame(55.7558, $message->location?->latitude);

        assertCount(1, $message->newChatMembers);
        assertSame(798, $message->newChatMembers[0]->id);

        assertSame(799, $message->leftChatMember?->id);
        assertSame('My Chat!', $message->newChatTitle);

        assertCount(1, $message->newChatPhoto);
        assertSame('newp1', $message->newChatPhoto[0]->fileId);

        assertTrue($message->deleteChatPhoto);
        assertTrue($message->groupChatCreated);
        assertTrue($message->supergroupChatCreated);
        assertTrue($message->channelChatCreated);
        assertSame(91, $message->messageAutoDeleteTimerChanged?->messageAutoDeleteTime);
        assertSame(341, $message->migrateToChatId);
        assertSame(182, $message->migrateFromChatId);
        assertSame(439, $message->pinnedMessage?->messageId);
        assertSame(101, $message->invoice?->totalAmount);
        assertSame('12732', $message->successfulPayment?->telegramPaymentChargeId);
        assertSame(12722, $message->usersShared?->requestId);
        assertSame(364, $message->chatShared?->requestId);
        assertSame('test-id1', $message->gift?->gift->id);
        assertSame('BaseName', $message->uniqueGift?->gift->baseName);
        assertSame('example.com', $message->connectedWebsite);
        assertSame('uqn', $message->writeAccessAllowed?->webAppName);
        assertSame('asdg23GWEH', $message->passportData?->credentials->hash);
        assertSame(7128, $message->proximityAlertTriggered?->traveler->id);
        assertSame(555, $message->boostAdded?->boostCount);
        assertSame('dark', $message->chatBackgroundSet?->type->themeName);
        assertSame('CreateName', $message->forumTopicCreated?->name);
        assertSame('EditName', $message->forumTopicEdited?->name);
        assertInstanceOf(ForumTopicClosed::class, $message->forumTopicClosed);
        assertInstanceOf(ForumTopicReopened::class, $message->forumTopicReopened);
        assertInstanceOf(GeneralForumTopicHidden::class, $message->generalForumTopicHidden);
        assertInstanceOf(GeneralForumTopicUnhidden::class, $message->generalForumTopicUnhidden);
        assertInstanceOf(GiveawayCreated::class, $message->giveawayCreated);
        assertSame(2981, $message->giveaway?->winnerCount);
        assertSame(4677, $message->giveawayWinners?->chat->id);
        assertSame(1679, $message->giveawayCompleted?->winnerCount);
        assertSame(1620000012, $message->videoChatScheduled?->startDate->getTimestamp());
        assertInstanceOf(VideoChatStarted::class, $message->videoChatStarted);
        assertSame(313, $message->videoChatEnded?->duration);
        assertSame(17313, $message->videoChatParticipantsInvited->users[0]->id);
        assertSame('important', $message->webAppData?->data);
        assertSame('Button1241', $message->replyMarkup->inlineKeyboard[0][0]->text);
        assertSame(1, $message->paidMedia?->starCount);
        assertEquals([new PaidMediaPhoto([])], $message->paidMedia?->paidMedia);
        assertEquals(new RefundedPayment('XTR', 12, 'ip', 'tpid'), $message->refundedPayment);
    }
}
