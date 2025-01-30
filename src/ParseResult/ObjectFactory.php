<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use DateTimeImmutable;
use LogicException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionProperty;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\BackgroundFillValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\BackgroundTypeValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\BooleanValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatBoostSourceValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatMemberValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\DateValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\FloatValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\MessageOriginValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ReactionTypeValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\RevenueWithdrawalStateValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\StringValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TransactionPartnerValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;
use Vjik\TelegramBot\Api\Type\BackgroundFill;
use Vjik\TelegramBot\Api\Type\BackgroundType;
use Vjik\TelegramBot\Api\Type\ChatBoostSource;
use Vjik\TelegramBot\Api\Type\ChatMember;
use Vjik\TelegramBot\Api\Type\MessageOrigin;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalState;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartner;
use Vjik\TelegramBot\Api\Type\ReactionType;

use function in_array;
use function is_array;
use function is_string;

final class ObjectFactory
{
    /**
     * @psalm-var array<string,ValueProcessorInterface>|null
     */
    private ?array $typeMap = null;

    /**
     * @throws TelegramParseResultException
     *
     * @psalm-template T
     * @psalm-param class-string<T> $className
     * @psalm-return T
     */
    public function create(mixed $value, ?string $key, string $className): object
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }

        $parameters = $this->getConstructorParameters($className);

        $arguments = [];
        foreach ($parameters as $name => $param) {
            $arguments[$name] = $this->handleParam($value, $param);
        }

        /** @psalm-suppress MixedMethodCall */
        return new $className(...$arguments);
    }

    private function handleParam(array $result, Param $param): mixed
    {
        if (!isset($result[$param->key])) {
            return $param->optional
                ? null
                : throw new NotFoundKeyInResultException($param->key);
        }

        if (is_string($param->type)) {
            return $this->create($result[$param->key], $param->key, $param->type);
        }

        return $param->type->process($result[$param->key], $param->key, $this);
    }

    /**
     * @psalm-param class-string $className
     * @psalm-return array<string,Param>
     */
    private function getConstructorParameters(string $className): array
    {
        $classReflection = new ReflectionClass($className);

        /** @psalm-var list<non-empty-string> $propertyNames */
        $propertyNames = [];
        foreach ($classReflection->getProperties(ReflectionProperty::IS_PUBLIC) as $propertyReflection) {
            if ($propertyReflection->isReadOnly()) {
                $propertyNames[] = $propertyReflection->getName();
            }
        }

        $constructorParameters = $classReflection->getConstructor()?->getParameters();

        /**
         * @psalm-suppress RiskyTruthyFalsyComparison We check whether constructor exists (not null) and has parameters
         * (non-empty array). If not - return empty array. If yes - continue.
         */
        if (empty($constructorParameters)) {
            return [];
        }

        $result = [];
        foreach ($constructorParameters as $parameter) {
            $name = $parameter->getName();
            if (in_array($name, $propertyNames, true)) {
                /** @psalm-suppress PossiblyNullArgument In this case `preg_replace()` always returns string */
                $key = strtolower(preg_replace('/[A-Z]/', '_$0', $name));
                $result[$name] = new Param(
                    $key,
                    $this->getParamType($parameter),
                    $parameter->isOptional(),
                );
            }
        }
        return $result;
    }

    /**
     * @psalm-return class-string|ValueProcessorInterface
     */
    private function getParamType(ReflectionParameter $parameter): string|ValueProcessorInterface
    {
        $attributes = $parameter->getAttributes(ValueProcessorInterface::class, ReflectionAttribute::IS_INSTANCEOF);
        if (!empty($attributes)) {
            return reset($attributes)->newInstance();
        }

        $typeReflection = $parameter->getType();
        if ($typeReflection instanceof ReflectionNamedType) {
            $name = $typeReflection->getName();
            return $this->getTypeMap()[$name]
                ?? (
                    class_exists($name)
                    ? $name
                    : throw new LogicException('Unsupported PHP type: ' . $name)
                );
        }

        throw new LogicException('Unsupported PHP type.');
    }

    /**
     * @psalm-return array<string, ValueProcessorInterface>
     */
    private function getTypeMap(): array
    {
        if ($this->typeMap === null) {
            $this->typeMap = [
                'string' => new StringValue(),
                'int' => new IntegerValue(),
                'float' => new FloatValue(),
                'true' => new TrueValue(),
                'bool' => new BooleanValue(),
                DateTimeImmutable::class => new DateValue(),
                ChatBoostSource::class => new ChatBoostSourceValue(),
                BackgroundFill::class => new BackgroundFillValue(),
                BackgroundType::class => new BackgroundTypeValue(),
                ChatMember::class => new ChatMemberValue(),
                MessageOrigin::class => new MessageOriginValue(),
                ReactionType::class => new ReactionTypeValue(),
                RevenueWithdrawalState::class => new RevenueWithdrawalStateValue(),
                TransactionPartner::class => new TransactionPartnerValue(),
            ];
        }
        return $this->typeMap;
    }
}
