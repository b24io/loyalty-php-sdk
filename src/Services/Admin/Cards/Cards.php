<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Common\Result\Cards\AddedCardResult;
use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Common\Result\Cards\CardsResult;
use B24io\Loyalty\SDK\Common\Result\Cards\CardStatus;
use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Services\AbstractService;
use Fig\Http\Message\RequestMethodInterface;
use Money\Money;
use MoneyPHP\Percentage\Percentage;
use Symfony\Component\Uid\Uuid;

class Cards extends AbstractService
{
    public function add(
        Uuid       $contactId,
        string     $number,
        Money      $balance,
        Percentage $percentage,
        CardStatus $cardStatus,
        string     $barcode = '',
        ?string    $externalId = null,
        ?Uuid      $cardLevelId = null,
        ?Uuid      $affiliateCardId = null,
        ?Uuid      $idempotencyKey = null): AddedCardResult
    {
        return new AddedCardResult($this->core->call(
            new Command(
                Context::admin(),
                RequestMethodInterface::METHOD_POST,
                'cards',
                [
                    'contact_id' => $contactId->toRfc4122(),
                    'number' => $number,
                    'balance' => [
                        'amount' => $this->decimalMoneyFormatter->format($balance),
                        'currency' => $balance->getCurrency()->getCode()
                    ],
                    'percentage' => (string)$percentage,
                    'status' => (string)$cardStatus,
                    'card_level_id' => ($nullsafeCardLevelId = $cardLevelId) ? $nullsafeCardLevelId->toRfc4122() : null,
                    'affiliate_card_id' => ($nullsafeAffiliateCardId = $affiliateCardId) ? $nullsafeAffiliateCardId->toRfc4122() : null,
                    'barcode' => $barcode,
                    'external_id' => $externalId
                ],
                null,
                null,
                $idempotencyKey
            )
        ));
    }

    public function getById(Uuid $id): CardItemResult
    {
        return new CardItemResult(
            $this->core->call(
                new Command(
                    Context::admin(),
                    RequestMethodInterface::METHOD_GET,
                    sprintf('cards/%s', $id->toRfc4122()),
                )
            )->getResponseData()->result
        );
    }

    public function list(ItemsOrder $order = null, ?int $page = 1): CardsResult
    {
        return new CardsResult(
            $this->core->call(
                new Command(
                    Context::admin(),
                    RequestMethodInterface::METHOD_GET,
                    'cards',
                    [],
                    $order,
                    $page
                )
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function count(): int
    {
        return (int)(new CardsResult(
            $this->core->call(
                new Command(
                    Context::admin(),
                    RequestMethodInterface::METHOD_GET,
                    'cards',
                    [],
                    null,
                    1
                )
            )
        ))->getCoreResponse()->getResponseData()->pagination->total;
    }
}