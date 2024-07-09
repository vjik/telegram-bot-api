<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Birthdate;
use Vjik\TelegramBot\Api\Type\BusinessIntro;
use Vjik\TelegramBot\Api\Type\BusinessLocation;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHours;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\ChatLocation;
use Vjik\TelegramBot\Api\Type\ChatPermissions;
use Vjik\TelegramBot\Api\Type\ChatPhoto;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;

final class ChatFullInfoTest extends TestCase
{
    public function testBase(): void
    {
        $info = new ChatFullInfo(23, 'private', 0x123456, 5);

        $this->assertSame(23, $info->id);
        $this->assertSame('private', $info->type);
        $this->assertSame(0x123456, $info->accentColorId);
        $this->assertSame(5, $info->maxReactionCount);
        $this->assertNull($info->title);
        $this->assertNull($info->username);
        $this->assertNull($info->firstName);
        $this->assertNull($info->lastName);
        $this->assertNull($info->isForum);
        $this->assertNull($info->photo);
        $this->assertNull($info->activeUsernames);
        $this->assertNull($info->birthdate);
        $this->assertNull($info->businessIntro);
        $this->assertNull($info->businessLocation);
        $this->assertNull($info->businessOpeningHours);
        $this->assertNull($info->personalChat);
        $this->assertNull($info->availableReactions);
        $this->assertNull($info->backgroundCustomEmojiId);
        $this->assertNull($info->profileAccentColorId);
        $this->assertNull($info->profileBackgroundCustomEmojiId);
        $this->assertNull($info->emojiStatusCustomEmojiId);
        $this->assertNull($info->emojiStatusExpirationDate);
        $this->assertNull($info->bio);
        $this->assertNull($info->hasPrivateForwards);
        $this->assertNull($info->hasRestrictedVoiceAndVideoMessages);
        $this->assertNull($info->joinToSendMessages);
        $this->assertNull($info->joinByRequest);
        $this->assertNull($info->description);
        $this->assertNull($info->inviteLink);
        $this->assertNull($info->pinnedMessage);
        $this->assertNull($info->permissions);
        $this->assertNull($info->slowModeDelay);
        $this->assertNull($info->unrestrictBoostCount);
        $this->assertNull($info->messageAutoDeleteTime);
        $this->assertNull($info->hasAggressiveAntiSpamEnabled);
        $this->assertNull($info->hasHiddenMembers);
        $this->assertNull($info->hasProtectedContent);
        $this->assertNull($info->hasVisibleHistory);
        $this->assertNull($info->stickerSetName);
        $this->assertNull($info->canSetStickerSet);
        $this->assertNull($info->customEmojiStickerSetName);
        $this->assertNull($info->linkedChatId);
        $this->assertNull($info->location);
        $this->assertNull($info->canSendPaidMedia);
    }

    public function testFromTelegramResult(): void
    {
        $info = (new ObjectFactory())->create([
            'id' => 23,
            'type' => 'private',
            'accent_color_id' => 0x123456,
            'max_reaction_count' => 5,
            'title' => 'Title',
            'username' => 'Bat',
            'first_name' => 'Bruce',
            'last_name' => 'Willy',
            'is_forum' => true,
            'photo' => [
                'small_file_id' => '123',
                'small_file_unique_id' => 'u123',
                'big_file_id' => '456',
                'big_file_unique_id' => 'u456',
            ],
            'active_usernames' => ['aka1', 'aka2'],
            'birthdate' => [
                'day' => 1,
                'month' => 2,
            ],
            'business_intro' => [
                'title' => 'My Business',
            ],
            'business_location' => [
                'address' => 'My Address',
            ],
            'business_opening_hours' => [
                'time_zone_name' => 'Europe/Moscow',
                'opening_hours' => [
                    [
                        'opening_minute' => 10,
                        'closing_minute' => 20,
                    ],
                ],
            ],
            'personal_chat' => [
                'id' => 42,
                'type' => 'private',
            ],
            'available_reactions' => [
                [
                    'type' => 'custom_emoji',
                    'custom_emoji_id' => '=)',
                ],
            ],
            'background_custom_emoji_id' => 'bge1',
            'profile_accent_color_id' => 0x654321,
            'profile_background_custom_emoji_id' => 'bge2',
            'emoji_status_custom_emoji_id' => 'bge3',
            'emoji_status_expiration_date' => 1717501903,
            'bio' => 'My Bio',
            'has_private_forwards' => true,
            'has_restricted_voice_and_video_messages' => true,
            'join_to_send_messages' => true,
            'join_by_request' => true,
            'description' => 'My Description',
            'invite_link' => 'https://t.me/joinchat/123',
            'pinned_message' => [
                'message_id' => 123,
                'date' => 1717501903,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
            ],
            'permissions' => [
                'can_send_messages' => true,
            ],
            'slow_mode_delay' => 5,
            'unrestrict_boost_count' => 10,
            'message_auto_delete_time' => 111,
            'has_aggressive_anti_spam_enabled' => true,
            'has_hidden_members' => true,
            'has_protected_content' => true,
            'has_visible_history' => true,
            'sticker_set_name' => 'MyStickerSet',
            'can_set_sticker_set' => true,
            'custom_emoji_sticker_set_name' => 'MyCustomEmojiStickerSet',
            'linked_chat_id' => 42,
            'location' => [
                'location' => [
                    'latitude' => 55.7558,
                    'longitude' => 37.6176,
                ],
                'address' => 'Moscow',
            ],
            'can_send_paid_media' => true,
        ], null, ChatFullInfo::class);

        $this->assertSame(23, $info->id);
        $this->assertSame('private', $info->type);
        $this->assertSame(0x123456, $info->accentColorId);
        $this->assertSame(5, $info->maxReactionCount);
        $this->assertSame('Title', $info->title);
        $this->assertSame('Bat', $info->username);
        $this->assertSame('Bruce', $info->firstName);
        $this->assertSame('Willy', $info->lastName);
        $this->assertTrue($info->isForum);

        $this->assertInstanceOf(ChatPhoto::class, $info->photo);
        $this->assertSame('123', $info->photo->smallFileId);

        $this->assertSame(['aka1', 'aka2'], $info->activeUsernames);

        $this->assertInstanceOf(Birthdate::class, $info->birthdate);
        $this->assertSame(1, $info->birthdate->day);

        $this->assertInstanceOf(BusinessIntro::class, $info->businessIntro);
        $this->assertSame('My Business', $info->businessIntro->title);

        $this->assertInstanceOf(BusinessLocation::class, $info->businessLocation);
        $this->assertSame('My Address', $info->businessLocation->address);

        $this->assertInstanceOf(BusinessOpeningHours::class, $info->businessOpeningHours);
        $this->assertSame('Europe/Moscow', $info->businessOpeningHours->timeZoneName);

        $this->assertInstanceOf(Chat::class, $info->personalChat);
        $this->assertSame(42, $info->personalChat->id);

        $this->assertIsArray($info->availableReactions);
        $this->assertCount(1, $info->availableReactions);
        $this->assertInstanceOf(ReactionTypeCustomEmoji::class, $info->availableReactions[0]);
        $this->assertSame('=)', $info->availableReactions[0]->customEmojiId);

        $this->assertSame('bge1', $info->backgroundCustomEmojiId);
        $this->assertSame(0x654321, $info->profileAccentColorId);
        $this->assertSame('bge2', $info->profileBackgroundCustomEmojiId);
        $this->assertSame('bge3', $info->emojiStatusCustomEmojiId);
        $this->assertSame(1717501903, $info->emojiStatusExpirationDate?->getTimestamp());
        $this->assertSame('My Bio', $info->bio);
        $this->assertTrue($info->hasPrivateForwards);
        $this->assertTrue($info->hasRestrictedVoiceAndVideoMessages);
        $this->assertTrue($info->joinToSendMessages);
        $this->assertTrue($info->joinByRequest);
        $this->assertSame('My Description', $info->description);
        $this->assertSame('https://t.me/joinchat/123', $info->inviteLink);

        $this->assertInstanceOf(Message::class, $info->pinnedMessage);
        $this->assertSame(123, $info->pinnedMessage->messageId);

        $this->assertInstanceOf(ChatPermissions::class, $info->permissions);
        $this->assertTrue($info->permissions->canSendMessages);

        $this->assertSame(5, $info->slowModeDelay);
        $this->assertSame(10, $info->unrestrictBoostCount);
        $this->assertSame(111, $info->messageAutoDeleteTime);
        $this->assertTrue($info->hasAggressiveAntiSpamEnabled);
        $this->assertTrue($info->hasHiddenMembers);
        $this->assertTrue($info->hasProtectedContent);
        $this->assertTrue($info->hasVisibleHistory);
        $this->assertSame('MyStickerSet', $info->stickerSetName);
        $this->assertTrue($info->canSetStickerSet);
        $this->assertSame('MyCustomEmojiStickerSet', $info->customEmojiStickerSetName);
        $this->assertSame(42, $info->linkedChatId);

        $this->assertInstanceOf(ChatLocation::class, $info->location);
        $this->assertSame(55.7558, $info->location->location->latitude);

        $this->assertTrue($info->canSendPaidMedia);
    }
}
