<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

final class InlineKeyboardMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $button = new InlineKeyboardButton('test');
        $markup = new InlineKeyboardMarkup([
            [$button]
        ]);

        $this->assertSame([[$button]], $markup->inlineKeyboard);

        $this->assertSame(
            [
                'inline_keyboard' => [
                    [
                        $button->toRequestArray(),
                    ],
                ],
            ],
            $markup->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $markup = (new ObjectFactory())->create([
            'inline_keyboard' => [
                [
                    [
                        'text' => 'test',
                    ],
                ],
            ],
        ], null, InlineKeyboardMarkup::class);

        $this->assertCount(1, $markup->inlineKeyboard);
        $this->assertCount(1, $markup->inlineKeyboard[0]);
        $this->assertInstanceOf(InlineKeyboardButton::class, $markup->inlineKeyboard[0][0]);
        $this->assertSame('test', $markup->inlineKeyboard[0][0]->text);
    }
}
