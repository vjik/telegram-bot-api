<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use JsonException;
use Psr\Log\LoggerInterface;
use SensitiveParameter;
use Vjik\TelegramBot\Api\ParseResult\ResultFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\Transport\TransportInterface;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

use function array_key_exists;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function json_decode;

/**
 * @internal
 */
final readonly class Api
{
    private ResultFactory $resultFactory;

    public function __construct(
        #[SensitiveParameter]
        private string $token,
        private string $baseUrl,
        private TransportInterface $transport,
    ) {
        $this->resultFactory = new ResultFactory();
    }

    /**
     * @see https://core.telegram.org/bots/api#making-requests
     *
     * @psalm-template TValue
     * @psalm-param MethodInterface<TValue> $method
     * @psalm-return TValue|FailResult
     */
    public function call(MethodInterface $method, ?LoggerInterface $logger): mixed
    {
        $logger?->info(
            'Send ' . $method->getHttpMethod()->value . '-request "' . $method->getApiMethod() . '".',
            LogContextFactory::sendRequest($method),
        );

        $response = $this->transport->send(
            $this->makeUrlPath($method->getApiMethod()),
            $method->getData(),
            $method->getHttpMethod(),
        );

        try {
            $decodedBody = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $logger?->error(
                'Failed to decode JSON from telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Failed to decode JSON response. Status code: ' . $response->statusCode . '.',
                previous: $e,
            );
        }

        if (!is_array($decodedBody)) {
            $logger?->error(
                'Incorrect telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Expected telegram response as array. Got "' . get_debug_type($decodedBody) . '".',
            );
        }

        if (!isset($decodedBody['ok']) || !is_bool($decodedBody['ok'])) {
            $logger?->error(
                'Incorrect "ok" field in telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Incorrect "ok" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        if ($decodedBody['ok']) {
            $result = $this->prepareSuccessResult($method, $response, $decodedBody, $logger);
            $logger?->info(
                'On "' . $method->getApiMethod() . '" request Telegram Bot API returned successful result.',
                LogContextFactory::successResult($method, $response, $decodedBody),
            );
        } else {
            $result = $this->prepareFailResult($method, $response, $decodedBody);
            $logger?->warning(
                'On "' . $method->getApiMethod() . '" request Telegram Bot API returned fail result.',
                LogContextFactory::failResult($method, $response, $decodedBody),
            );
        }

        return $result;
    }

    private function makeUrlPath(string $apiMethod): string
    {
        return $this->baseUrl . '/bot' . $this->token . '/' . $apiMethod;
    }

    /**
     * @psalm-template TValue
     * @psalm-param MethodInterface<TValue> $method
     * @psalm-return TValue
     */
    private function prepareSuccessResult(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedBody,
        ?LoggerInterface $logger,
    ): mixed {
        if (!array_key_exists('result', $decodedBody)) {
            $logger?->error(
                'Not found "result" field in telegram response.',
                LogContextFactory::parseResultError($response->body),
            );
            throw new TelegramParseResultException(
                'Not found "result" field in response. Status code: ' . $response->statusCode . '.',
            );
        }

        $resultType = $method->getResultType();

        try {
            return $this->resultFactory->create($decodedBody['result'], $resultType);
        } catch (TelegramParseResultException $exception) {
            $logger?->error(
                'Failed to parse telegram result. ' . $exception->getMessage(),
                LogContextFactory::parseResultError($response->body),
            );
            throw $exception;
        }
    }

    private function prepareFailResult(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedBody,
    ): FailResult {
        return new FailResult(
            $method,
            $response,
            (isset($decodedBody['description']) && is_string($decodedBody['description']))
                ? $decodedBody['description']
                : null,
            ResponseParameters::fromDecodedBody($decodedBody),
            (isset($decodedBody['error_code']) && is_int($decodedBody['error_code']))
                ? $decodedBody['error_code']
                : null,
        );
    }
}
