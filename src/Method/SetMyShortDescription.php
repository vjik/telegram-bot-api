<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setmyshortdescription
 */
final readonly class SetMyShortDescription implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?string $shortDescription = null,
        private ?string $languageCode = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMyShortDescription';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'short_description' => $this->shortDescription,
                'language_code' => $this->languageCode,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
