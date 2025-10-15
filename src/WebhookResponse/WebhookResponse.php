<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

use function json_encode;

/**
 * @api
 */
final readonly class WebhookResponse
{
    /**
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public static function prepareJson(MethodInterface $method): string
    {
        return json_encode(
            self::prepareData($method),
            JSON_THROW_ON_ERROR,
        );
    }

    /**
     * @throws MethodNotSupportedException If {@see InputFile} is used in method data.
     */
    public static function prepareData(MethodInterface $method): array
    {
        $data = $method->getData();
        self::assertDataSupport($data);

        return [
            'method' => $method->getApiMethod(),
            ...$method->getData(),
        ];
    }

    public static function isSupported(MethodInterface $method): bool
    {
        try {
            self::assertDataSupport($method->getData());
            return true;
        } catch (MethodNotSupportedException) {
            return false;
        }
    }

    /**
     * @throws MethodNotSupportedException If {@see InputFile} is used in method data.
     */
    private static function assertDataSupport(array $data): void
    {
        foreach ($data as $value) {
            if ($value instanceof InputFile) {
                throw new MethodNotSupportedException('InputFile is not supported in Webhook response.');
            }
        }
    }
}
