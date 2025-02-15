<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorSelfie;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorSelfieTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorSelfie('driver_license', 'qwerty', 'Test message');

        assertSame('selfie', $type->getSource());
        assertSame(
            [
                'source' => 'selfie',
                'type' => 'driver_license',
                'file_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
