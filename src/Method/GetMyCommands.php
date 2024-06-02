<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScope;

/**
 * @see https://core.telegram.org/bots/api#getmycommands
 */
final readonly class GetMyCommands implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?BotCommandScope $scope = null,
        private ?string $languageCode = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyCommands';
    }

    public function getData(): array
    {
        return array_filter([
            'scope' => $this->scope?->toRequestArray(),
            'language_code' => $this->languageCode,
        ]);
    }

    /**
     * @return BotCommand[]
     */
    public function prepareResult(mixed $result): array
    {
        ValueHelper::assertArrayResult($result);
        return array_map(
            static fn($item) => BotCommand::fromTelegramResult($item),
            $result
        );
    }
}
