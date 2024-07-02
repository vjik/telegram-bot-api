<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ExternalReplyInfo;
use Vjik\TelegramBot\Api\Type\MessageOriginUser;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\User;

final class ExternalReplyInfoTest extends TestCase
{
    public function testBase(): void
    {
        $origin = new MessageOriginUser(new DateTimeImmutable(), new User(123, false, 'Vjik'));
        $externalReplyInfo = new ExternalReplyInfo($origin);

        $this->assertSame($origin, $externalReplyInfo->origin);
        $this->assertNull($externalReplyInfo->chat);
        $this->assertNull($externalReplyInfo->messageId);
        $this->assertNull($externalReplyInfo->linkPreviewOptions);
        $this->assertNull($externalReplyInfo->animation);
        $this->assertNull($externalReplyInfo->audio);
        $this->assertNull($externalReplyInfo->document);
        $this->assertNull($externalReplyInfo->photo);
        $this->assertNull($externalReplyInfo->sticker);
        $this->assertNull($externalReplyInfo->story);
        $this->assertNull($externalReplyInfo->video);
        $this->assertNull($externalReplyInfo->videoNote);
        $this->assertNull($externalReplyInfo->voice);
        $this->assertNull($externalReplyInfo->hasMediaSpoiler);
        $this->assertNull($externalReplyInfo->contact);
        $this->assertNull($externalReplyInfo->dice);
        $this->assertNull($externalReplyInfo->game);
        $this->assertNull($externalReplyInfo->giveaway);
        $this->assertNull($externalReplyInfo->giveawayWinners);
        $this->assertNull($externalReplyInfo->invoice);
        $this->assertNull($externalReplyInfo->location);
        $this->assertNull($externalReplyInfo->poll);
        $this->assertNull($externalReplyInfo->venue);
        $this->assertNull($externalReplyInfo->paidMedia);
    }

    public function testFromTelegramResult(): void
    {
        $externalReplyInfo = ExternalReplyInfo::fromTelegramResult([
            'origin' => [
                'type' => 'user',
                'date' => 1620000000,
                'sender_user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Vjik',
                ],
            ],
            'chat' => [
                'id' => 44,
                'type' => 'private',
            ],
            'message_id' => 97,
            'link_preview_options' => [
                'url' => 'https://example.com/hello',
            ],
            'animation' => [
                'file_id' => 'f1',
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
            'giveaway' => [
                'chats' => [],
                'winners_selection_date' => 1620000000,
                'winner_count' => 35,
            ],
            'giveaway_winners' => [
                'chat' => [
                    'id' => 46,
                    'type' => 'private',
                ],
                'giveaway_message_id' => 3461,
                'winners_selection_date' => 1620000002,
                'winner_count' => 0,
                'winners' => [],
            ],
            'invoice' => [
                'title' => 'Invoice',
                'description' => 'Description',
                'start_parameter' => 'start',
                'currency' => 'USD',
                'total_amount' => 101,
            ],
            'location' => [
                'latitude' => 55.7558,
                'longitude' => 37.6176,
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
            'paid_media' => [
                'star_count' => 1,
                'paid_media' => [
                    [
                        'type' => 'photo',
                        'photo' => [],
                    ],
                ],
            ],
        ]);

        $this->assertInstanceOf(MessageOriginUser::class, $externalReplyInfo->origin);
        $this->assertSame(123, $externalReplyInfo->origin->senderUser->id);

        $this->assertSame(44, $externalReplyInfo->chat?->id);
        $this->assertSame(97, $externalReplyInfo->messageId);
        $this->assertSame('https://example.com/hello', $externalReplyInfo->linkPreviewOptions?->url);
        $this->assertSame('f1', $externalReplyInfo->animation?->fileId);
        $this->assertSame('f2', $externalReplyInfo->audio?->fileId);
        $this->assertSame('f3', $externalReplyInfo->document?->fileId);

        $this->assertCount(1, $externalReplyInfo->photo);
        $this->assertSame('f4', $externalReplyInfo->photo[0]->fileId);

        $this->assertSame('f5', $externalReplyInfo->sticker?->fileId);
        $this->assertSame(99, $externalReplyInfo->story?->id);
        $this->assertSame('f6', $externalReplyInfo->video?->fileId);
        $this->assertSame('f7', $externalReplyInfo->videoNote?->fileId);
        $this->assertSame('f8', $externalReplyInfo->voice?->fileId);
        $this->assertTrue($externalReplyInfo->hasMediaSpoiler);
        $this->assertSame('+1234567890', $externalReplyInfo->contact?->phoneNumber);
        $this->assertSame('🎲', $externalReplyInfo->dice?->emoji);
        $this->assertSame('Game', $externalReplyInfo->game?->title);
        $this->assertSame(35, $externalReplyInfo->giveaway?->winnerCount);
        $this->assertSame(3461, $externalReplyInfo->giveawayWinners?->giveawayMessageId);
        $this->assertSame(101, $externalReplyInfo->invoice?->totalAmount);
        $this->assertSame(55.7558, $externalReplyInfo->location?->latitude);
        $this->assertSame('pid2354', $externalReplyInfo->poll?->id);
        $this->assertSame('Venue1', $externalReplyInfo->venue?->title);
        $this->assertSame(1, $externalReplyInfo->paidMedia?->starCount);
        $this->assertEquals([new PaidMediaPhoto([])], $externalReplyInfo->paidMedia?->paidMedia);
    }
}
