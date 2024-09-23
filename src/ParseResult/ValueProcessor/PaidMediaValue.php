<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\PaidMedia;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;
use Vjik\TelegramBot\Api\Type\PaidMediaVideo;

/**
 * @template-extends InterfaceValue<PaidMedia>
 */
final readonly class PaidMediaValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'preview' => PaidMediaPreview::class,
            'photo' => PaidMediaPhoto::class,
            'video' => PaidMediaVideo::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown paid media type.';
    }
}
