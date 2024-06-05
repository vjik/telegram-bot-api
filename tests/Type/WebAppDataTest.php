<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\WebAppData;

final class WebAppDataTest extends TestCase
{
    public function testBase(): void
    {
        $webAppData = new WebAppData('test', 'label');

        $this->assertSame('test', $webAppData->data);
        $this->assertSame('label', $webAppData->buttonText);
    }

    public function testFromTelegramResult(): void
    {
        $webAppData = WebAppData::fromTelegramResult([
            'data' => 'test',
            'button_text' => 'label',
        ]);

        $this->assertSame('test', $webAppData->data);
        $this->assertSame('label', $webAppData->buttonText);
    }
}
