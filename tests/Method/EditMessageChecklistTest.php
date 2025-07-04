<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\EditMessageChecklist;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputChecklist;
use Vjik\TelegramBot\Api\Type\InputChecklistTask;

use function PHPUnit\Framework\assertSame;

final class EditMessageChecklistTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditMessageChecklist(
            'bcid1',
            12,
            35,
            new InputChecklist(
                'Title',
                [
                    new InputChecklistTask(1, 'Task 1'),
                    new InputChecklistTask(2, 'Task 2'),
                ],
            ),
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editMessageChecklist', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_id' => 35,
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
        $replyMarkup = new InlineKeyboardMarkup([]);
        $method = new EditMessageChecklist(
            'bcid1',
            12,
            35,
            $checklist,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_id' => 35,
                'checklist' => $checklist->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageChecklist(
            'bcid1',
            12,
            35,
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
