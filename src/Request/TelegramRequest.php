<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

use Vjik\TelegramBot\Api\Type\InputFile;

final readonly class TelegramRequest implements
    TelegramRequestWithFilesInterface,
    TelegramRequestWithResultPreparingInterface
{
    /**
     * @var callable|null
     */
    private mixed $successCallback;

    /**
     * @psalm-param array<string,mixed> $data
     * @psalm-param array<string,InputFile> $files
     */
    public function __construct(
        private HttpMethod $httpMethod,
        private string $apiMethod,
        private array $data = [],
        private array $files = [],
        ?callable $successCallback = null,
    ) {
        $this->successCallback = $successCallback;
    }

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }

    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function prepareResult(mixed $result): mixed
    {
        return $this->successCallback === null
            ? $result
            : call_user_func($this->successCallback, $result);
    }
}
