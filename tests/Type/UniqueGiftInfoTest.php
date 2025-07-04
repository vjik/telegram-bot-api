<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;
use Vjik\TelegramBot\Api\Type\UniqueGiftBackdrop;
use Vjik\TelegramBot\Api\Type\UniqueGiftBackdropColors;
use Vjik\TelegramBot\Api\Type\UniqueGiftInfo;
use Vjik\TelegramBot\Api\Type\UniqueGift;
use Vjik\TelegramBot\Api\Type\UniqueGiftModel;
use Vjik\TelegramBot\Api\Type\UniqueGiftSymbol;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftInfoTest extends TestCase
{
    public function testBase(): void
    {
        $gift = new UniqueGift(
            'baseName',
            'uniqueName',
            1,
            new UniqueGiftModel(
                'id1',
                new Sticker(
                    'x1',
                    'fullX1',
                    'unique',
                    100,
                    120,
                    false,
                    true,
                ),
                200,
            ),
            new UniqueGiftSymbol(
                'id2',
                new Sticker(
                    'x1',
                    'fullX1',
                    'unique',
                    100,
                    120,
                    false,
                    true,
                ),
                200,
            ),
            new UniqueGiftBackdrop(
                'id3',
                new UniqueGiftBackdropColors(1, 2, 3, 4),
                200,
            ),
        );
        $uniqueGiftInfo = new UniqueGiftInfo($gift, 'upgrade');

        assertSame($gift, $uniqueGiftInfo->gift);
        assertSame('upgrade', $uniqueGiftInfo->origin);
        assertNull($uniqueGiftInfo->ownedGiftId);
        assertNull($uniqueGiftInfo->transferStarCount);
        assertNull($uniqueGiftInfo->lastResaleStarCount);
        assertNull($uniqueGiftInfo->nextTransferDate);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'gift' =>  [
                'base_name' => 'BaseName',
                'name' => 'uniqueName',
                'number' => 1,
                'model' => [
                    'name' => 'test1',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'unique',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'rarity_per_mille' => 200,
                ],
                'symbol' => [
                    'name' => 'test2',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'unique',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'rarity_per_mille' => 200,
                ],
                'backdrop' => [
                    'name' => 'test3',
                    'colors' => [
                        'center_color' => 1,
                        'edge_color' => 2,
                        'symbol_color' => 3,
                        'text_color' => 4,
                    ],
                    'rarity_per_mille' => 200,
                ],
            ],
            'origin' => 'transfer',
            'last_resale_star_count' => 99,
            'owned_gift_id' => 'owned-id1',
            'transfer_star_count' => 15,
            'next_transfer_date' => 1700000000,
        ], null, UniqueGiftInfo::class);

        assertInstanceOf(UniqueGiftInfo::class, $type);
        assertInstanceOf(UniqueGift::class, $type->gift);
        assertSame('transfer', $type->origin);
        assertSame('owned-id1', $type->ownedGiftId);
        assertSame(15, $type->transferStarCount);
        assertSame(99, $type->lastResaleStarCount);
        assertSame(1700000000, $type->nextTransferDate?->getTimestamp());
    }
}
