<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\CopyTextButton;

final class CopyTextButtonTest extends TestCase
{
    public function testBase(): void
    {
        $type = new CopyTextButton('test');

        $this->assertSame('test', $type->text);
        $this->assertSame(
            [
                'text' => 'test',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'text' => 'test',
            ],
            null,
            CopyTextButton::class,
        );

        $this->assertSame('test', $type->text);
    }
}
