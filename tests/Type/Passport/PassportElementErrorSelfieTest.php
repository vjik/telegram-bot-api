<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorSelfie;

final class PassportElementErrorSelfieTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorSelfie('driver_license', 'qwerty', 'Test message');

        $this->assertSame('selfie', $type->getSource());
        $this->assertSame(
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
