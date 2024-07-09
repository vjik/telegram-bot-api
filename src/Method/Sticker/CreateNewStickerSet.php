<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\RequestFileCollector;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;

/**
 * @see https://core.telegram.org/bots/api#createnewstickerset
 */
final readonly class CreateNewStickerSet implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param InputSticker[] $stickers
     */
    public function __construct(
        private int $userId,
        private string $name,
        private string $title,
        private array $stickers,
        private ?string $stickerType = null,
        private ?bool $needsRepainting = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'createNewStickerSet';
    }

    public function getData(): array
    {
        $fileCollector = new RequestFileCollector();
        $stickers = array_map(
            static function (InputSticker $sticker) use ($fileCollector): array {
                return $sticker->toRequestArray($fileCollector);
            },
            $this->stickers,
        );

        return array_filter(
            [
                'user_id' => $this->userId,
                'name' => $this->name,
                'title' => $this->title,
                'stickers' => $stickers,
                'sticker_type' => $this->stickerType,
                'needs_repainting' => $this->needsRepainting,
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
