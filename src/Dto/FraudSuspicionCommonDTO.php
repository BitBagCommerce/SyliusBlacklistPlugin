<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Dto;

use Sylius\Component\Order\Model\OrderInterface;

class FraudSuspicionCommonDTO
{
    public function __construct(
        public ?OrderInterface $order,
        public ?object $customer,
        public ?string $company,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $phoneNumber,
        public ?string $street,
        public ?string $city,
        public ?string $province,
        public ?string $country,
        public ?string $postcode,
        public ?string $customerIp,
    ) {
    }
}
