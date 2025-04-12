<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Type\Sticker\Gift;

/**
 * @see https://core.telegram.org/bots/api#giftinfo
 *
 * @api
 */
final readonly class GiftInfo
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public Gift $gift,
        public ?string $ownedGiftId = null,
        public ?int $convertStarCount = null,
        public ?int $prepaidUpgradeStarCount = null,
        public ?true $canBeUpgraded = null,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isPrivate = null,
    ) {}
}
