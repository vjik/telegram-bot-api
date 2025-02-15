<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorReverseSide;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorReverseSideTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorReverseSide('driver_license', 'qwerty', 'Test message');

        assertSame('reverse_side', $type->getSource());
        assertSame(
            [
                'source' => 'reverse_side',
                'type' => 'driver_license',
                'file_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
