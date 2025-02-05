<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;

/**
 * @see https://core.telegram.org/bots/api#addstickertoset
 *
 * @template-implements MethodInterface<true>
 */
final readonly class AddStickerToSet implements MethodInterface
{
    public function __construct(
        private int $userId,
        private string $name,
        private InputSticker $sticker,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'addStickerToSet';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $sticker = $this->sticker->toRequestArray($fileCollector);

        return [
            'user_id' => $this->userId,
            'name' => $this->name,
            'sticker' => $sticker,
            ...$fileCollector->get(),
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
