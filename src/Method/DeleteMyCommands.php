<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotCommandScope;

/**
 * @see https://core.telegram.org/bots/api#deletemycommands
 */
final readonly class DeleteMyCommands implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?BotCommandScope $scope = null,
        private ?string $languageCode = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteMyCommands';
    }

    public function getData(): array
    {
        return array_filter([
            'scope' => $this->scope?->toRequestArray(),
            'language_code' => $this->languageCode,
        ]);
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
