<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendChecklist;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputChecklist;
use Vjik\TelegramBot\Api\Type\InputChecklistTask;

use Vjik\TelegramBot\Api\Type\ReplyParameters;

use function PHPUnit\Framework\assertSame;

final class SendChecklistTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendChecklist(
            'bcid1',
            12,
            new InputChecklist(
                'Title',
                [
                    new InputChecklistTask(1, 'Task 1'),
                    new InputChecklistTask(2, 'Task 2'),
                ],
            ),
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendChecklist', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'checklist' => [
                    'title' => 'Title',
                    'tasks' => [
                        ['id' => 1, 'text' => 'Task 1'],
                        ['id' => 2, 'text' => 'Task 2'],
                    ],
                ],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $checklist = new InputChecklist(
            'Title',
            [
                new InputChecklistTask(1, 'Task 1'),
                new InputChecklistTask(2, 'Task 2'),
            ],
        );
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new InlineKeyboardMarkup([]);
        $method = new SendChecklist(
            'bcid1',
            12,
            $checklist,
            true,
            false,
            'test',
            $replyParameters,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'checklist' => $checklist->toRequestArray(),
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'test',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendChecklist(
            'bcid1',
            12,
            new InputChecklist('Title', []),
        );

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        assertSame(7, $preparedResult->messageId);
    }
}
