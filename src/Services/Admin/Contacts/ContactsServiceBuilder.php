<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;

class ContactsServiceBuilder extends AbstractServiceBuilder
{
    public function contacts(): Contacts
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Contacts($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function fetcher(): ContactsFetcher
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new ContactsFetcher(
                new Contacts(
                    $this->core,
                    $this->log
                ),
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}