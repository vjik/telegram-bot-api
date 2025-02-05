<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#uploadstickerfile
 *
 * @template-implements MethodInterface<File>
 */
final readonly class UploadStickerFile implements MethodInterface
{
    public function __construct(
        private int $userId,
        private InputFile $sticker,
        private string $stickerFormat,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'uploadStickerFile';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'sticker' => $this->sticker,
            'sticker_format' => $this->stickerFormat,
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(File::class);
    }
}
