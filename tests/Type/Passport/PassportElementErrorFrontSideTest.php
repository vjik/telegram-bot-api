<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorFrontSide;

final class PassportElementErrorFrontSideTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorFrontSide('driver_license', 'qwerty', 'Test message');

        $this->assertSame('front_side', $type->getSource());
        $this->assertSame(
            [
                'source' => 'front_side',
                'type' => 'driver_license',
                'file_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
