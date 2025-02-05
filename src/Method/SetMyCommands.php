<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScope;

/**
 * @see https://core.telegram.org/bots/api#setmycommands
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetMyCommands implements MethodInterface
{
    /**
     * @param BotCommand[] $commands
     */
    public function __construct(
        private array $commands,
        private ?BotCommandScope $scope = null,
        private ?string $languageCode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMyCommands';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'commands' => array_map(
                    static fn(BotCommand $botCommand) => $botCommand->toRequestArray(),
                    $this->commands,
                ),
                'scope' => $this->scope?->toRequestArray(),
                'language_code' => $this->languageCode,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
