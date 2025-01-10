<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#setstickersetthumbnail
 *
 * @template-implements TelegramRequestInterface<TrueValue>
 */
final readonly class SetStickerSetThumbnail implements TelegramRequestInterface
{
    public function __construct(
        private string $name,
        private int $userId,
        private string $format,
        private InputFile|string|null $thumbnail = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerSetThumbnail';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'name' => $this->name,
                'user_id' => $this->userId,
                'thumbnail' => $this->thumbnail,
                'format' => $this->format,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
