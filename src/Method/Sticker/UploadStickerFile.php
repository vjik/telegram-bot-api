<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#uploadstickerfile
 *
 * @template-implements TelegramRequestInterface<class-string<File>>
 */
final readonly class UploadStickerFile implements TelegramRequestInterface
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

    public function getResultType(): string
    {
        return File::class;
    }
}
