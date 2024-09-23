<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotShortDescription;

/**
 * @see https://core.telegram.org/bots/api#getmyshortdescription
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<BotShortDescription>>
 */
final readonly class GetMyShortDescription implements TelegramRequestWithResultPreparingInterface
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
        return 'getMyShortDescription';
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
        return BotShortDescription::class;
    }
}
