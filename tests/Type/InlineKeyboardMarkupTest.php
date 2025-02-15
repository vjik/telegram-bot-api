<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InlineKeyboardMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $button = new InlineKeyboardButton('test');
        $markup = new InlineKeyboardMarkup([
            [$button],
        ]);

        assertSame([[$button]], $markup->inlineKeyboard);

        assertSame(
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

        assertCount(1, $markup->inlineKeyboard);
        assertCount(1, $markup->inlineKeyboard[0]);
        assertInstanceOf(InlineKeyboardButton::class, $markup->inlineKeyboard[0][0]);
        assertSame('test', $markup->inlineKeyboard[0][0]->text);
    }
}
