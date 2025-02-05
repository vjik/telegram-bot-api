<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\BotShortDescription;

/**
 * @see https://core.telegram.org/bots/api#getmyshortdescription
 *
 * @template-implements MethodInterface<BotShortDescription>
 */
final readonly class GetMyShortDescription implements MethodInterface
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

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(BotShortDescription::class);
    }
}
