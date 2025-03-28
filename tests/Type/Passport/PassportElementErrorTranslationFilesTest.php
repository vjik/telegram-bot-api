<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorTranslationFiles;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorTranslationFilesTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorTranslationFiles('rental_agreement', ['qwerty'], 'Test message');

        assertSame('translation_files', $type->getSource());
        assertSame(
            [
                'source' => 'translation_files',
                'type' => 'rental_agreement',
                'file_hashes' => ['qwerty'],
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
