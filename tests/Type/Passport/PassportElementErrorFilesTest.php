<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorFiles;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorFilesTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorFiles('rental_agreement', ['qwerty'], 'Test message');

        assertSame('files', $type->getSource());
        assertSame(
            [
                'source' => 'files',
                'type' => 'rental_agreement',
                'file_hashes' => ['qwerty'],
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
