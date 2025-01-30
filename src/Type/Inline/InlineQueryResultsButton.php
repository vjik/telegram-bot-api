<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use Vjik\TelegramBot\Api\Type\WebAppInfo;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultsbutton
 *
 * @api
 */
final readonly class InlineQueryResultsButton
{
    public function __construct(
        public string $text,
        public ?WebAppInfo $webApp = null,
        public ?string $startParameter = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'web_app' => $this->webApp?->toRequestArray(),
                'start_parameter' => $this->startParameter,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
