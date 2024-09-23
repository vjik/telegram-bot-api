<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotDescription;

/**
 * @see https://core.telegram.org/bots/api#getmydescription
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<BotDescription>>
 */
final readonly class GetMyDescription implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?string $languageCode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyDescription';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'language_code' => $this->languageCode,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return BotDescription::class;
    }
}
