<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\File;

/**
 * @see https://core.telegram.org/bots/api#getfile
 *
 * @template-implements MethodInterface<File>
 */
final readonly class GetFile implements MethodInterface
{
    public function __construct(
        private string $fileId,
    ) {}

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

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(File::class);
    }
}
