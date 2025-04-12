<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\OwnedGifts;

/**
 * @see https://core.telegram.org/bots/api#getbusinessaccountgifts
 *
 * @template-implements MethodInterface<OwnedGifts>
 *
 * @api
 */
final readonly class GetBusinessAccountGifts implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private ?bool $excludeUnsaved = null,
        private ?bool $excludeSaved = null,
        private ?bool $excludeUnlimited = null,
        private ?bool $excludeLimited = null,
        private ?bool $excludeUnique = null,
        private ?bool $sortByPrice = null,
        private ?string $offset = null,
        private ?int $limit = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getBusinessAccountGifts';
    }

    public function getData(): array
    {
        return array_filter([
            'business_connection_id' => $this->businessConnectionId,
            'exclude_unsaved' => $this->excludeUnsaved,
            'exclude_saved' => $this->excludeSaved,
            'exclude_unlimited' => $this->excludeUnlimited,
            'exclude_limited' => $this->excludeLimited,
            'exclude_unique' => $this->excludeUnique,
            'sort_by_price' => $this->sortByPrice,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn($value) => $value !== null);
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(OwnedGifts::class);
    }
}
