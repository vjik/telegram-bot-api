<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\RequestFileCollector;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;

/**
 * @see https://core.telegram.org/bots/api#replacestickerinset
 */
final readonly class ReplaceStickerInSet implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int $userId,
        private string $name,
        private string $oldSticker,
        private InputSticker $sticker,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'replaceStickerInSet';
    }

    public function getData(): array
    {
        $fileCollector = new RequestFileCollector();
        $sticker = $this->sticker->toRequestArray($fileCollector);

        return [
            'user_id' => $this->userId,
            'name' => $this->name,
            'old_sticker' => $this->oldSticker,
            'sticker' => $sticker,
            ...$fileCollector->get(),
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
