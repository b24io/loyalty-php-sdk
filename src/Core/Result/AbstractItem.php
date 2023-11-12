<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Result;

use ArrayIterator;
use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Core\Exceptions\ImmutableResultViolationException;
use DateTimeImmutable;
use Exception;
use IteratorAggregate;
use Symfony\Component\Uid\Uuid;
use Traversable;

abstract class AbstractItem implements IteratorAggregate
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __isset(int|string $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param int|string $offset
     *
     * @return mixed
     * @throws Exception
     */
    public function __get(int|string $offset)
    {
        switch ($offset) {
            case 'id':
                return Uuid::fromString($this->data[$offset]);
            case 'created':
            case 'modified':
                return new DateTimeImmutable($this->data[$offset]);
            case 'reason':
                return new Reason(
                    $this->data[$offset]['id'],
                    $this->data[$offset]['code'],
                    $this->data[$offset]['comment']
                );
            default:
                return $this->data[$offset] ?? null;
        }

    }

    /**
     * @param int|string $offset
     * @param mixed $value
     *
     * @return void
     * @throws ImmutableResultViolationException
     *
     */
    public function __set(int|string $offset, mixed $value)
    {
        throw new ImmutableResultViolationException(sprintf('Result is immutable, violation at offset %s', $offset));
    }

    /**
     * @param int|string $offset
     *
     * @throws ImmutableResultViolationException
     */
    public function __unset(int|string $offset)
    {
        throw new ImmutableResultViolationException(sprintf('Result is immutable, violation at offset %s', $offset));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function isKeyExists(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
}