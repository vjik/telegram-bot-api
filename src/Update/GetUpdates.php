<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#getupdates
 */
final readonly class GetUpdates implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        private ?int $offset = null,
        private ?int $limit = null,
        private ?int $timeout = null,
        private ?array $allowedUpdates = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getUpdates';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'offset' => $this->offset,
                'limit' => $this->limit,
                'timeout' => $this->timeout,
                'allowed_updates' => $this->allowedUpdates,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    /**
     * @return Update[]
     */
    public function prepareResult(mixed $result): array
    {
        ValueHelper::assertArrayResult($result);
        return array_map(
            static fn(mixed $row) => Update::fromTelegramResult($row),
            $result,
        );
    }
}
