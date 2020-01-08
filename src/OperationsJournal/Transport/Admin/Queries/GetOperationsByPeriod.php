<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Transport\Admin\Queries;

use B24io\Loyalty\SDK\Exceptions\ObjectInitializationException;
use DateTime;
use \Symfony\Component\HttpFoundation;

/**
 * Class GetOperationsByPeriod
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Transport\Admin\Queries
 */
class GetOperationsByPeriod
{
    /**
     * @var DateTime
     */
    protected $dateFrom;
    /**
     * @var DateTime
     */
    protected $dateTo;

    /**
     * GetOperationsByPeriod constructor.
     *
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     */
    public function __construct(DateTime $dateFrom, DateTime $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return DateTime
     */
    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @return DateTime
     */
    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param HttpFoundation\Request $request
     *
     * @return static
     * @throws ObjectInitializationException
     */
    public static function initFromRequest(HttpFoundation\Request $request): self
    {
        $dateFrom = $request->get('dateFrom', null);
        $dateTo = $request->get('dateTo', null);
        if ($dateFrom === null) {
            throw new ObjectInitializationException(sprintf('argument dateFrom not found'));
        }
        if ($dateTo === null) {
            throw new ObjectInitializationException(sprintf('argument dateTo not found'));
        }
        $dateFrom = \DateTime::createFromFormat(\DATE_RFC3339, $dateFrom);
        if ($dateFrom === false) {
            throw new ObjectInitializationException(sprintf('DateTime object initialization error for argument dateFrom [%s]', $dateFrom));
        }
        $dateTo = \DateTime::createFromFormat(\DATE_RFC3339, $dateTo);
        if ($dateTo === false) {
            throw new ObjectInitializationException(sprintf('DateTime object initialization error for argument dateTo [%s]', $dateTo));
        }

        return new self($dateFrom, $dateTo);
    }
}