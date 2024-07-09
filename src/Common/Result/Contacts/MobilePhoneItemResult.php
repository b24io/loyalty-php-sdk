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
 * @property-read PhoneNumber $phoneNumber
 * @property-read VerificationStatus $verificationStatus
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
            case 'verificationStatus':
                return new VerificationStatus($this->data['verification_status']);
            case 'phoneNumber':
                $phoneNumberUtil = PhoneNumberUtil::getInstance();
                if ($phoneNumberUtil === null) {
                    throw new InvalidArgumentException('cannot create libphonenumber util instance');
                }
                return $phoneNumberUtil->parse($this->data['number'], '');
            default:
                return parent::__get($offset);
        }
    }
}