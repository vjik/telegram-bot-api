<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Type\InputProfilePhoto;

/**
 * @see https://core.telegram.org/bots/api#setbusinessaccountprofilephoto
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class SetBusinessAccountProfilePhoto implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private InputProfilePhoto $photo,
        private ?bool $isPublic = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setBusinessAccountProfilePhoto';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $photo = $this->photo->toRequestArray($fileCollector);

        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'photo' => $photo,
                'is_public' => $this->isPublic,
                ...$fileCollector->get(),
            ],
            static fn($value) => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
