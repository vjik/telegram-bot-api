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

final class MessageTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $chat = new Chat(1, 'private');
        $message = new Message(7, $date, $chat);

        $this->assertSame(7, $message->messageId);
        $this->assertSame($date, $message->date);
        $this->assertSame($chat, $message->chat);
        $this->assertNull($message->messageThreadId);
        $this->assertNull($message->from);
        $this->assertNull($message->senderChat);
        $this->assertNull($message->senderBoostCount);
        $this->assertNull($message->senderBusinessBot);
        $this->assertNull($message->businessConnectionId);
        $this->assertNull($message->forwardOrigin);
        $this->assertNull($message->isTopicMessage);
        $this->assertNull($message->isAutomaticForward);
        $this->assertNull($message->replyToMessage);
        $this->assertNull($message->externalReply);
        $this->assertNull($message->quote);
        $this->assertNull($message->replyToStory);
        $this->assertNull($message->viaBot);
        $this->assertNull($message->editDate);
        $this->assertNull($message->hasProtectedContent);
        $this->assertNull($message->isFromOffline);
        $this->assertNull($message->mediaGroupId);
        $this->assertNull($message->authorSignature);
        $this->assertNull($message->text);
        $this->assertNull($message->entities);
        $this->assertNull($message->linkPreviewOptions);
        $this->assertNull($message->effectId);
        $this->assertNull($message->animation);
        $this->assertNull($message->audio);
        $this->assertNull($message->document);
        $this->assertNull($message->photo);
        $this->assertNull($message->sticker);
        $this->assertNull($message->story);
        $this->assertNull($message->video);
        $this->assertNull($message->videoNote);
        $this->assertNull($message->voice);
        $this->assertNull($message->caption);
        $this->assertNull($message->captionEntities);
        $this->assertNull($message->showCaptionAboveMedia);
        $this->assertNull($message->hasMediaSpoiler);
        $this->assertNull($message->contact);
        $this->assertNull($message->dice);
        $this->assertNull($message->game);
        $this->assertNull($message->poll);
        $this->assertNull($message->venue);
        $this->assertNull($message->location);
        $this->assertNull($message->newChatMembers);
        $this->assertNull($message->leftChatMember);
        $this->assertNull($message->newChatTitle);
        $this->assertNull($message->newChatPhoto);
        $this->assertNull($message->deleteChatPhoto);
        $this->assertNull($message->groupChatCreated);
        $this->assertNull($message->supergroupChatCreated);
        $this->assertNull($message->channelChatCreated);
        $this->assertNull($message->messageAutoDeleteTimerChanged);
        $this->assertNull($message->migrateToChatId);
        $this->assertNull($message->migrateFromChatId);
        $this->assertNull($message->pinnedMessage);
        $this->assertNull($message->invoice);
        $this->assertNull($message->successfulPayment);
        $this->assertNull($message->usersShared);
        $this->assertNull($message->chatShared);
        $this->assertNull($message->connectedWebsite);
        $this->assertNull($message->writeAccessAllowed);
        $this->assertNull($message->passportData);
        $this->assertNull($message->proximityAlertTriggered);
        $this->assertNull($message->boostAdded);
        $this->assertNull($message->chatBackgroundSet);
        $this->assertNull($message->forumTopicCreated);
        $this->assertNull($message->forumTopicEdited);
        $this->assertNull($message->forumTopicClosed);
        $this->assertNull($message->forumTopicReopened);
        $this->assertNull($message->generalForumTopicHidden);
        $this->assertNull($message->generalForumTopicUnhidden);
        $this->assertNull($message->giveawayCreated);
        $this->assertNull($message->giveaway);
        $this->assertNull($message->giveawayWinners);
        $this->assertNull($message->giveawayCompleted);
        $this->assertNull($message->videoChatScheduled);
        $this->assertNull($message->videoChatStarted);
        $this->assertNull($message->videoChatEnded);
        $this->assertNull($message->videoChatParticipantsInvited);
        $this->assertNull($message->webAppData);
        $this->assertNull($message->replyMarkup);
        $this->assertNull($message->refundedPayment);
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
                ]
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

        $this->assertSame(7, $message->messageId);
        $this->assertSame(1620000000, $message->date->getTimestamp());
        $this->assertSame(1, $message->chat->id);
        $this->assertSame(3, $message->messageThreadId);
        $this->assertSame(7, $message->from?->id);
        $this->assertSame(9, $message->senderChat?->id);
        $this->assertSame(11, $message->senderBoostCount);
        $this->assertSame(15, $message->senderBusinessBot?->id);
        $this->assertSame('btest', $message->businessConnectionId);

        $this->assertInstanceOf(MessageOriginHiddenUser::class, $message->forwardOrigin);
        $this->assertSame('bat', $message->forwardOrigin?->senderUserName);

        $this->assertTrue($message->isTopicMessage);
        $this->assertTrue($message->isAutomaticForward);
        $this->assertSame(17, $message->replyToMessage?->messageId);

        $this->assertInstanceOf(ExternalReplyInfo::class, $message->externalReply);
        $this->assertSame('cat', $message->externalReply->origin?->senderUserName);

        $this->assertSame('test93', $message->quote?->text);
        $this->assertSame(8863, $message->replyToStory?->id);
        $this->assertSame(127, $message->viaBot?->id);
        $this->assertSame(65416841123, $message->editDate?->getTimestamp());
        $this->assertTrue($message->hasProtectedContent);
        $this->assertTrue($message->isFromOffline);
        $this->assertSame('mg34613', $message->mediaGroupId);
        $this->assertSame('as235', $message->authorSignature);
        $this->assertSame('Hello, World!', $message->text);

        $this->assertCount(1, $message->entities);
        $this->assertSame(53, $message->entities[0]->length);

        $this->assertSame('https://example.com/lpo', $message->linkPreviewOptions?->url);
        $this->assertSame('e235', $message->effectId);
        $this->assertSame('an1', $message->animation?->fileId);
        $this->assertSame('f2', $message->audio?->fileId);
        $this->assertSame('f3', $message->document?->fileId);

        $this->assertCount(1, $message->photo);
        $this->assertSame('f4', $message->photo[0]->fileId);

        $this->assertSame('f5', $message->sticker?->fileId);
        $this->assertSame(99, $message->story?->id);
        $this->assertSame('f6', $message->video?->fileId);
        $this->assertSame('f7', $message->videoNote?->fileId);
        $this->assertSame('f8', $message->voice?->fileId);
        $this->assertSame('Hello!', $message->caption);

        $this->assertCount(1, $message->captionEntities);
        $this->assertSame(124, $message->captionEntities[0]->length);

        $this->assertTrue($message->showCaptionAboveMedia);
        $this->assertTrue($message->hasMediaSpoiler);
        $this->assertSame('+1234567890', $message->contact?->phoneNumber);
        $this->assertSame('🎲', $message->dice?->emoji);
        $this->assertSame('Game', $message->game?->title);
        $this->assertSame('pid2354', $message->poll?->id);
        $this->assertSame('Venue1', $message->venue?->title);
        $this->assertSame(55.7558, $message->location?->latitude);

        $this->assertCount(1, $message->newChatMembers);
        $this->assertSame(798, $message->newChatMembers[0]->id);

        $this->assertSame(799, $message->leftChatMember?->id);
        $this->assertSame('My Chat!', $message->newChatTitle);

        $this->assertCount(1, $message->newChatPhoto);
        $this->assertSame('newp1', $message->newChatPhoto[0]->fileId);

        $this->assertTrue($message->deleteChatPhoto);
        $this->assertTrue($message->groupChatCreated);
        $this->assertTrue($message->supergroupChatCreated);
        $this->assertTrue($message->channelChatCreated);
        $this->assertSame(91, $message->messageAutoDeleteTimerChanged?->messageAutoDeleteTime);
        $this->assertSame(341, $message->migrateToChatId);
        $this->assertSame(182, $message->migrateFromChatId);
        $this->assertSame(439, $message->pinnedMessage?->messageId);
        $this->assertSame(101, $message->invoice?->totalAmount);
        $this->assertSame('12732', $message->successfulPayment?->telegramPaymentChargeId);
        $this->assertSame(12722, $message->usersShared?->requestId);
        $this->assertSame(364, $message->chatShared?->requestId);
        $this->assertSame('example.com', $message->connectedWebsite);
        $this->assertSame('uqn', $message->writeAccessAllowed?->webAppName);
        $this->assertSame('asdg23GWEH', $message->passportData?->credentials->hash);
        $this->assertSame(7128, $message->proximityAlertTriggered?->traveler->id);
        $this->assertSame(555, $message->boostAdded?->boostCount);
        $this->assertSame('dark', $message->chatBackgroundSet?->type->themeName);
        $this->assertSame('CreateName', $message->forumTopicCreated?->name);
        $this->assertSame('EditName', $message->forumTopicEdited?->name);
        $this->assertInstanceOf(ForumTopicClosed::class, $message->forumTopicClosed);
        $this->assertInstanceOf(ForumTopicReopened::class, $message->forumTopicReopened);
        $this->assertInstanceOf(GeneralForumTopicHidden::class, $message->generalForumTopicHidden);
        $this->assertInstanceOf(GeneralForumTopicUnhidden::class, $message->generalForumTopicUnhidden);
        $this->assertInstanceOf(GiveawayCreated::class, $message->giveawayCreated);
        $this->assertSame(2981, $message->giveaway?->winnerCount);
        $this->assertSame(4677, $message->giveawayWinners?->chat->id);
        $this->assertSame(1679, $message->giveawayCompleted?->winnerCount);
        $this->assertSame(1620000012, $message->videoChatScheduled?->startDate->getTimestamp());
        $this->assertInstanceOf(VideoChatStarted::class, $message->videoChatStarted);
        $this->assertSame(313, $message->videoChatEnded?->duration);
        $this->assertSame(17313, $message->videoChatParticipantsInvited->users[0]->id);
        $this->assertSame('important', $message->webAppData?->data);
        $this->assertSame('Button1241', $message->replyMarkup->inlineKeyboard[0][0]->text);
        $this->assertSame(1, $message->paidMedia?->starCount);
        $this->assertEquals([new PaidMediaPhoto([])], $message->paidMedia?->paidMedia);
        $this->assertEquals(new RefundedPayment('XTR', 12, 'ip', 'tpid'), $message->refundedPayment);
    }
}
