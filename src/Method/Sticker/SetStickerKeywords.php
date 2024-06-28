<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setstickerkeywords
 */
final readonly class SetStickerKeywords implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param string[]|null $keywords
     */
    public function __construct(
        private string $sticker,
        private ?array $keywords = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setStickerKeywords';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'sticker' => $this->sticker,
                'keywords' => $this->keywords,
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
