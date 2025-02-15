<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\CopyTextButton;

use function PHPUnit\Framework\assertSame;

final class CopyTextButtonTest extends TestCase
{
    public function testBase(): void
    {
        $type = new CopyTextButton('test');

        assertSame('test', $type->text);
        assertSame(
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

        assertSame('test', $type->text);
    }
}
