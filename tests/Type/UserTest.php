<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class UserTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Sergei');

        assertSame(1, $user->id);
        assertSame(false, $user->isBot);
        assertSame('Sergei', $user->firstName);
        assertNull($user->lastName);
        assertNull($user->username);
        assertNull($user->languageCode);
        assertNull($user->isPremium);
        assertNull($user->addedToAttachmentMenu);
        assertNull($user->canJoinGroups);
        assertNull($user->canReadAllGroupMessages);
        assertNull($user->supportsInlineQueries);
        assertNull($user->canConnectToBusiness);
        assertNull($user->hasMainWebApp);
    }

    public function testToRequestArray(): void
    {
        $user = new User(
            1,
            false,
            'Sergei',
            'Ivanov',
            'sergei_ivanov',
            'ru-RU',
            true,
            true,
            true,
            true,
            true,
            true,
            false,
        );

        assertSame(
            [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
                'last_name' => 'Ivanov',
                'username' => 'sergei_ivanov',
                'language_code' => 'ru-RU',
                'is_premium' => true,
                'added_to_attachment_menu' => true,
                'can_join_groups' => true,
                'can_read_all_group_messages' => true,
                'supports_inline_queries' => true,
                'can_connect_to_business' => true,
                'has_main_web_app' => false,
            ],
            $user->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $user = (new ObjectFactory())->create([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
            'last_name' => 'Ivanov',
            'username' => 'sergei_ivanov',
            'language_code' => 'ru-RU',
            'is_premium' => true,
            'added_to_attachment_menu' => true,
            'can_join_groups' => true,
            'can_read_all_group_messages' => true,
            'supports_inline_queries' => true,
            'can_connect_to_business' => true,
            'has_main_web_app' => false,
        ], null, User::class);

        assertInstanceOf(User::class, $user);
        assertSame(1, $user->id);
        assertSame(false, $user->isBot);
        assertSame('Sergei', $user->firstName);
        assertSame('Ivanov', $user->lastName);
        assertSame('sergei_ivanov', $user->username);
        assertSame('ru-RU', $user->languageCode);
        assertSame(true, $user->isPremium);
        assertSame(true, $user->addedToAttachmentMenu);
        assertSame(true, $user->canJoinGroups);
        assertSame(true, $user->canReadAllGroupMessages);
        assertSame(true, $user->supportsInlineQueries);
        assertSame(true, $user->canConnectToBusiness);
        assertSame(false, $user->hasMainWebApp);
    }
}
