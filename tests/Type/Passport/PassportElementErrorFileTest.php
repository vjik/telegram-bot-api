<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorFile;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorFileTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorFile('passport_registration', 'qwerty', 'Test message');

        assertSame('file', $type->getSource());
        assertSame(
            [
                'source' => 'file',
                'type' => 'passport_registration',
                'file_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
