<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @api
 */
final readonly class WebhookResponse
{
    private string $apiMethod;
    private array $apiData;

    public function __construct(MethodInterface $method)
    {
        $this->apiMethod = $method->getApiMethod();
        $this->apiData = $method->getData();
    }

    /**
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function getData(): array
    {
        $this->assertSupport();

        return [
            'method' => $this->apiMethod,
            ...$this->apiData,
        ];
    }

    public function isSupported(): bool
    {
        try {
            $this->assertSupport();
            return true;
        } catch (MethodNotSupportedException) {
            return false;
        }
    }

    /**
     * @throws MethodNotSupportedException If {@see InputFile} is used in method data.
     */
    private function assertSupport(): void
    {
        foreach ($this->apiData as $value) {
            if ($value instanceof InputFile) {
                throw new MethodNotSupportedException('InputFile is not supported in Webhook response.');
            }
        }
    }
}
