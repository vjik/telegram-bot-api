<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\User;

final class UserTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Sergei');

        $this->assertSame(1, $user->id);
        $this->assertSame(false, $user->isBot);
        $this->assertSame('Sergei', $user->firstName);
        $this->assertNull($user->lastName);
        $this->assertNull($user->username);
        $this->assertNull($user->languageCode);
        $this->assertNull($user->isPremium);
        $this->assertNull($user->addedToAttachmentMenu);
        $this->assertNull($user->canJoinGroups);
        $this->assertNull($user->canReadAllGroupMessages);
        $this->assertNull($user->supportsInlineQueries);
        $this->assertNull($user->canConnectToBusiness);
        $this->assertNull($user->hasMainWebApp);
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

        $this->assertSame(
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

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(1, $user->id);
        $this->assertSame(false, $user->isBot);
        $this->assertSame('Sergei', $user->firstName);
        $this->assertSame('Ivanov', $user->lastName);
        $this->assertSame('sergei_ivanov', $user->username);
        $this->assertSame('ru-RU', $user->languageCode);
        $this->assertSame(true, $user->isPremium);
        $this->assertSame(true, $user->addedToAttachmentMenu);
        $this->assertSame(true, $user->canJoinGroups);
        $this->assertSame(true, $user->canReadAllGroupMessages);
        $this->assertSame(true, $user->supportsInlineQueries);
        $this->assertSame(true, $user->canConnectToBusiness);
        $this->assertSame(false, $user->hasMainWebApp);
    }
}
