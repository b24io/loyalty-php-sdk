<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Unit\Common;

use B24io\Loyalty\SDK\Common\VerificationStatus;
use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;
use Generator;
use PHPUnit\Framework\TestCase;
use Throwable;

class VerificationStatusTest extends TestCase
{
    /**
     * @param string $verificationStatus
     * @param Throwable|null $throwable
     * @return void
     * @throws InvalidArgumentException
     * @dataProvider verificationStatusesDataProvider
     */
    public function testConstruct(string $verificationStatus, ?Throwable $throwable): void
    {
        if ($throwable instanceof Throwable) {
            $this->expectException(get_class($throwable));
        }

        $status = new VerificationStatus($verificationStatus);

        $this->assertEquals((string)$status, $verificationStatus);
    }

    public static function verificationStatusesDataProvider(): Generator
    {
        yield 'unverified' => [
            'unverified',
            null
        ];
        yield 'verified' => [
            'verified',
            null
        ];
        yield 'in_process' => [
            'in_process',
            null
        ];
        yield 'unknown_state' => [
            'unknown_state',
            new InvalidArgumentException()
        ];
    }
}
