<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Contacts;

use B24io\Loyalty\SDK\Common\VerificationStatus;
use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;
use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use Exception;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;


/**
 * @property-read VerificationStatus $verificationStatus
 * @property-read PhoneNumber $number
 */
class MobilePhoneItemResult extends AbstractItem
{
    /**
     * @param int|string $offset
     * @throws Exception
     */
    public function __get($offset)
    {
        switch ($offset) {
            case 'number':
                $phoneNumberUtil = PhoneNumberUtil::getInstance();
                if ($phoneNumberUtil === null) {
                    throw new InvalidArgumentException('cannot create libphonenumber util instance');
                }
                return $phoneNumberUtil->parse($this->data[$offset], null);
            case 'verificationStatus':
                return new VerificationStatus($this->data['verification_status']);
            default:
                return parent::__get($offset);
        }
    }
}