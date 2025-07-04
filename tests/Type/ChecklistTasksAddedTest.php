<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChecklistTask;
use Vjik\TelegramBot\Api\Type\ChecklistTasksAdded;
use Vjik\TelegramBot\Api\Type\Message;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChecklistTasksAddedTest extends TestCase
{
    public function testBase(): void
    {
        $tasks = [new ChecklistTask(1, 'Task 1')];
        $type = new ChecklistTasksAdded($tasks);

        assertSame($tasks, $type->tasks);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'tasks' => [
                [
                    'id' => 1,
                    'text' => 'Task 1',
                ],
            ],
            'checklist_message' => [
                'message_id' => 17,
                'date' => 1620000001,
                'chat' => [
                    'id' => 2,
                    'type' => 'private',
                ],
            ],
        ];

        $type = (new ObjectFactory())->create($result, null, ChecklistTasksAdded::class);

        assertEquals([new ChecklistTask(1, 'Task 1')], $type->tasks);

        assertInstanceOf(Message::class, $type->checklistMessage);
        assertSame(17, $type->checklistMessage->messageId);
    }
}
