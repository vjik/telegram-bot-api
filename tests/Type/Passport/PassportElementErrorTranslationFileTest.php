<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorTranslationFile;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorTranslationFileTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorTranslationFile('driver_license', 'qwerty', 'Test message');

        assertSame('translation_file', $type->getSource());
        assertSame(
            [
                'source' => 'translation_file',
                'type' => 'driver_license',
                'file_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
