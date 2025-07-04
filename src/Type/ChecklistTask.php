<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#checklisttask
 *
 * @api
 */
final readonly class ChecklistTask
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public int $id,
        public string $text,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $textEntities = null,
        public ?User $completedByUser = null,
        public ?DateTimeImmutable $completionDate = null,
    ) {}
}
