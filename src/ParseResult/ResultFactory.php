<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;

final readonly class ResultFactory
{
    private ObjectFactory $objectFactory;

    public function __construct()
    {
        $this->objectFactory = new ObjectFactory();
    }

    /**
     * @psalm-param class-string|ValueProcessorInterface $type
     */
    public function create(mixed $result, string|ValueProcessorInterface $type): mixed
    {
        if (is_string($type)) {
            $type = new ObjectValue($type);
        }
        /** @var ValueProcessorInterface $type */

        return $type->process($result, null, $this->objectFactory);
    }
}
