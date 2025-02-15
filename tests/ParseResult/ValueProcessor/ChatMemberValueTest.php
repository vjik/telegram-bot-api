<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatMemberValue;
use Vjik\TelegramBot\Api\Type\ChatMemberAdministrator;
use Vjik\TelegramBot\Api\Type\ChatMemberBanned;
use Vjik\TelegramBot\Api\Type\ChatMemberLeft;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;
use Vjik\TelegramBot\Api\Type\ChatMemberOwner;
use Vjik\TelegramBot\Api\Type\ChatMemberRestricted;

use function PHPUnit\Framework\assertInstanceOf;

final class ChatMemberValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                ChatMemberOwner::class,
                [
                    'status' => 'creator',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                    'is_anonymous' => false,
                ],
            ],
            [
                ChatMemberAdministrator::class,
                [
                    'status' => 'administrator',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                    'can_be_edited' => true,
                    'is_anonymous' => false,
                    'can_manage_chat' => true,
                    'can_delete_messages' => true,
                    'can_manage_video_chats' => true,
                    'can_restrict_members' => true,
                    'can_promote_members' => true,
                    'can_change_info' => true,
                    'can_invite_users' => true,
                    'can_post_stories' => true,
                    'can_edit_stories' => true,
                    'can_delete_stories' => true,
                ],
            ],
            [
                ChatMemberMember::class,
                [
                    'status' => 'member',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                ChatMemberRestricted::class,
                [
                    'status' => 'restricted',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                    'is_member' => true,
                    'can_send_messages' => false,
                    'can_send_audios' => false,
                    'can_send_documents' => false,
                    'can_send_photos' => false,
                    'can_send_videos' => false,
                    'can_send_video_notes' => false,
                    'can_send_voice_notes' => false,
                    'can_send_polls' => false,
                    'can_send_other_messages' => false,
                    'can_add_web_page_previews' => false,
                    'can_change_info' => false,
                    'can_invite_users' => false,
                    'can_pin_messages' => false,
                    'can_manage_topics' => true,
                    'until_date' => 123456789,
                ],
            ],
            [
                ChatMemberLeft::class,
                [
                    'status' => 'left',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                ChatMemberBanned::class,
                [
                    'status' => 'kicked',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                    'until_date' => 123456789,
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ChatMemberValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ChatMemberValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown chat member status.');
        $processor->process(['status' => 'test'], null, $objectFactory);
    }
}
