<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\WebAppData;

use function PHPUnit\Framework\assertSame;

final class WebAppDataTest extends TestCase
{
    public function testBase(): void
    {
        $webAppData = new WebAppData('test', 'label');

        assertSame('test', $webAppData->data);
        assertSame('label', $webAppData->buttonText);
    }

    public function testFromTelegramResult(): void
    {
        $webAppData = (new ObjectFactory())->create([
            'data' => 'test',
            'button_text' => 'label',
        ], null, WebAppData::class);

        assertSame('test', $webAppData->data);
        assertSame('label', $webAppData->buttonText);
    }
}
