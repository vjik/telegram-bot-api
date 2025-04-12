<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Type\Sticker\Gift;

/**
 * @see https://core.telegram.org/bots/api#ownedgiftregular
 *
 * @api
 */
final readonly class OwnedGiftRegular implements OwnedGift
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public Gift $gift,
        public DateTimeImmutable $sendDate,
        public ?string $ownedGiftId = null,
        public ?User $senderUser = null,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isPrivate = null,
        public ?true $isSaved = null,
        public ?true $canBeUpgraded = null,
        public ?true $wasRefunded = null,
        public ?int $convertStarCount = null,
        public ?int $prepaidUpgradeStarCount = null,
    ) {}

    public function getType(): string
    {
        return 'regular';
    }
}
