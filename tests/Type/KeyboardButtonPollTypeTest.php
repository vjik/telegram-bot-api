<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\KeyboardButtonPollType;

final class KeyboardButtonPollTypeTest extends TestCase
{
    public function testBase(): void
    {
        $keyboardButtonPollType = new KeyboardButtonPollType();

        $this->assertNull($keyboardButtonPollType->type);

        $this->assertSame([], $keyboardButtonPollType->toRequestArray());
    }

    public function testFilled(): void
    {
        $keyboardButtonPollType = new KeyboardButtonPollType('test');

        $this->assertSame('test', $keyboardButtonPollType->type);

        $this->assertSame(
            [
                'type' => 'test',
            ],
            $keyboardButtonPollType->toRequestArray(),
        );
    }
}
