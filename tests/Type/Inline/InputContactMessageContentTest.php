<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;

final class InputContactMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputContactMessageContent('+70001234567', 'John');

        $this->assertSame('+70001234567', $type->phoneNumber);
        $this->assertSame('John', $type->firstName);
        $this->assertNull($type->lastName);
        $this->assertNull($type->vcard);

        $this->assertSame(
            [
                'phone_number' => '+70001234567',
                'first_name' => 'John',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $type = new InputContactMessageContent('+70001234567', 'John', 'Doe', 'vcard!');

        $this->assertSame('+70001234567', $type->phoneNumber);
        $this->assertSame('John', $type->firstName);
        $this->assertSame('Doe', $type->lastName);
        $this->assertSame('vcard!', $type->vcard);

        $this->assertSame(
            [
                'phone_number' => '+70001234567',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'vcard' => 'vcard!',
            ],
            $type->toRequestArray(),
        );
    }
}
