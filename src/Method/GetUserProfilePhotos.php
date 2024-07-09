<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\UserProfilePhotos;

/**
 * @see https://core.telegram.org/bots/api#getuserprofilephotos
 */
final readonly class GetUserProfilePhotos implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int $userId,
        private ?int $offset = null,
        private ?int $limit = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getUserProfilePhotos';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'offset' => $this->offset,
                'limit' => $this->limit,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return UserProfilePhotos::class;
    }
}
