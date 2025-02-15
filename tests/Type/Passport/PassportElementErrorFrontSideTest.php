<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorFrontSide;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorFrontSideTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorFrontSide('driver_license', 'qwerty', 'Test message');

        assertSame('front_side', $type->getSource());
        assertSame(
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
