<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Dto;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Order\Model\OrderInterface;

class FraudSuspicionCommonDTO
{
    public function __construct(
        public ?OrderInterface $order = null,
        public ?CustomerInterface $customer = null,
        public ?string $company = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $phoneNumber = null,
        public ?string $street = null,
        public ?string $city = null,
        public ?string $province = null,
        public ?string $country = null,
        public ?string $postcode = null,
        public ?string $customerIp = null,
    ) {
    }
}
