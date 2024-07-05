<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Game;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Game\SendGame;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendGameTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendGame(12, 'Racing');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendGame', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'game_short_name' => 'Racing',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $method = new SendGame(
            12,
            'Racing',
            'bcid1',
            99,
            false,
            true,
            'meid',
            $replyParameters,
            $replyMarkup,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'game_short_name' => 'Racing',
                'disable_notification' => false,
                'protect_content' => true,
                'message_effect_id' => 'meid',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendGame(12, 'Racing');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
