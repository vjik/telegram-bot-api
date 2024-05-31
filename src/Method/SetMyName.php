<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setmyname
 */
final class SetMyName implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?string $name = null,
        private ?string $languageCode = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMyName';
    }

    public function getData(): array
    {
        return array_filter([
            'name' => $this->name,
            'language_code' => $this->languageCode,
        ]);
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
