<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorUnspecified;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorUnspecifiedTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorUnspecified('driver_license', 'qwerty', 'Test message');

        assertSame('unspecified', $type->getSource());
        assertSame(
            [
                'source' => 'unspecified',
                'type' => 'driver_license',
                'element_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
