<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\File;

/**
 * @see https://core.telegram.org/bots/api#getfile
 */
final readonly class GetFile implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        public string $fileId,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getFile';
    }

    public function getData(): array
    {
        return [
            'file_id' => $this->fileId,
        ];
    }

    public function prepareResult(mixed $result): File
    {
        return File::fromTelegramResult($result);
    }
}
