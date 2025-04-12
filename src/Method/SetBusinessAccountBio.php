<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#setbusinessaccountbio
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class SetBusinessAccountBio implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private ?string $bio = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setBusinessAccountBio';
    }

    public function getData(): array
    {
        $data = [
            'business_connection_id' => $this->businessConnectionId,
        ];

        if ($this->bio !== null) {
            $data['bio'] = $this->bio;
        }

        return $data;
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
