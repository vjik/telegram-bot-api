<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\KeyboardButtonRequestUsers;

final class KeyboardButtonRequestUsersTest extends TestCase
{
    public function testBase(): void
    {
        $keyboardButtonRequestUsers = new KeyboardButtonRequestUsers(1);

        $this->assertSame(1, $keyboardButtonRequestUsers->requestId);
        $this->assertNull($keyboardButtonRequestUsers->userIsBot);
        $this->assertNull($keyboardButtonRequestUsers->userIsPremium);
        $this->assertNull($keyboardButtonRequestUsers->maxQuantity);
        $this->assertNull($keyboardButtonRequestUsers->requestName);
        $this->assertNull($keyboardButtonRequestUsers->requestUsername);
        $this->assertNull($keyboardButtonRequestUsers->requestPhoto);

        $this->assertSame(
            [
                'request_id' => 1,
            ],
            $keyboardButtonRequestUsers->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $keyboardButtonRequestUsers = new KeyboardButtonRequestUsers(
            1,
            true,
            false,
            5,
            true,
            true,
            false,
        );

        $this->assertSame(1, $keyboardButtonRequestUsers->requestId);
        $this->assertTrue($keyboardButtonRequestUsers->userIsBot);
        $this->assertFalse($keyboardButtonRequestUsers->userIsPremium);
        $this->assertSame(5, $keyboardButtonRequestUsers->maxQuantity);
        $this->assertTrue($keyboardButtonRequestUsers->requestName);
        $this->assertTrue($keyboardButtonRequestUsers->requestUsername);
        $this->assertFalse($keyboardButtonRequestUsers->requestPhoto);

        $this->assertSame(
            [
                'request_id' => 1,
                'user_is_bot' => true,
                'user_is_premium' => false,
                'max_quantity' => 5,
                'request_name' => true,
                'request_username' => true,
                'request_photo' => false,
            ],
            $keyboardButtonRequestUsers->toRequestArray(),
        );
    }
}
