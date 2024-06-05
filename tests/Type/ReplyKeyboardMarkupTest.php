<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\KeyboardButton;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;

final class ReplyKeyboardMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $button = new KeyboardButton('text');
        $markup = new ReplyKeyboardMarkup([[$button]]);

        $this->assertSame([[$button]], $markup->keyboard);
        $this->assertNull($markup->isPersistent);
        $this->assertNull($markup->resizeKeyboard);
        $this->assertNull($markup->oneTimeKeyboard);
        $this->assertNull($markup->inputFieldPlaceholder);
        $this->assertNull($markup->selective);

        $this->assertSame(
            [
                'keyboard' => [[['text' => 'text']]],
            ],
            $markup->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $button = new KeyboardButton('text');
        $markup = new ReplyKeyboardMarkup([[$button]], true, false, true, 'test', true);

        $this->assertSame([[$button]], $markup->keyboard);
        $this->assertTrue($markup->isPersistent);
        $this->assertFalse($markup->resizeKeyboard);
        $this->assertTrue($markup->oneTimeKeyboard);
        $this->assertSame('test', $markup->inputFieldPlaceholder);
        $this->assertTrue($markup->selective);

        $this->assertSame(
            [
                'keyboard' => [[['text' => 'text']]],
                'is_persistent' => true,
                'resize_keyboard' => false,
                'one_time_keyboard' => true,
                'input_field_placeholder' => 'test',
                'selective' => true,
            ],
            $markup->toRequestArray(),
        );
    }
}
