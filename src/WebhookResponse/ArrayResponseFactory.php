<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use LogicException;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

final readonly class ArrayResponseFactory
{
    public function create(MethodInterface $method): array
    {
        $data = $method->getData();
        foreach ($data as $value) {
            if ($value instanceof InputFile) {
                throw new LogicException('InputFile is not supported in Webhook response.');
            }
        }

        return [
            'method' => $method->getApiMethod(),
            ...$method->getData(),
        ];
    }
}
