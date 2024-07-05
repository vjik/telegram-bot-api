<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Passport\PassportFile;

final class PassportFileTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $passportFile = new PassportFile('1', '2', 3, $date);

        $this->assertSame('1', $passportFile->fileId);
        $this->assertSame('2', $passportFile->fileUniqueId);
        $this->assertSame(3, $passportFile->fileSize);
        $this->assertSame($date, $passportFile->fileDate);
    }

    public function testFromTelegramResult(): void
    {
        $passportFile = (new ObjectFactory())->create([
            'file_id' => '1',
            'file_unique_id' => '2',
            'file_size' => 3,
            'file_date' => 1717512173,
        ], null, PassportFile::class);

        $this->assertSame('1', $passportFile->fileId);
        $this->assertSame('2', $passportFile->fileUniqueId);
        $this->assertSame(3, $passportFile->fileSize);
        $this->assertEquals(new DateTimeImmutable('@1717512173'), $passportFile->fileDate);
    }
}
