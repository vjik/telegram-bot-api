<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultsButton;
use Vjik\TelegramBot\Api\Type\WebAppInfo;

final class InlineQueryResultsButtonTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultsButton('test');

        $this->assertSame(
            [
                'text' => 'test',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $webApp = new WebAppInfo('https://example.com');
        $type = new InlineQueryResultsButton('test', $webApp, 'start');

        $this->assertSame(
            [
                'text' => 'test',
                'web_app' => $webApp->toRequestArray(),
                'start_parameter' => 'start',
            ],
            $type->toRequestArray(),
        );
    }
}
