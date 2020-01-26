<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FabricTest
 *
 * @package B24io\Loyalty\SDK\Cards\DTO
 */
final class FabricTest extends TestCase
{
    /**
     * @covers \B24io\Loyalty\SDK\Cards\DTO\Fabric::initFromArray
     */
    public function testCreateCardFromArray(): void
    {
        $card = [
            'number'     => '12345',
            'barcode'    => '',
            'status'     => 'active',
            'user'       => [
                'user-id' => '123',
            ],
            'balance'    => [
                'amount'   => '1000',
                'currency' => 'RUB',
            ],
            'percentage' => '10.5',
            'created'    => (new \DateTime())->format(\DATE_RFC3339),
            'modified'   => (new \DateTime())->format(\DATE_RFC3339),
            'uuid'       => Uuid::uuid4(),
        ];

        $cardDto = Fabric::initFromArray($card);
        $this->assertEquals($cardDto->getNumber(), $card['number']);
    }
}