<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Model;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Order\Model\OrderInterface;

interface FraudSuspicionCommonModelInterface
{
    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order): void;

    public function getCustomer(): ?CustomerInterface;

    public function setCustomer(CustomerInterface $customer): void;

    public function getCompany(): ?string;

    public function setCompany(?string $company);

    public function getFirstName(): ?string;

    public function setFirstName(?string $firstName);

    public function getLastName(): ?string;

    public function setLastName(?string $lastName);

    public function getEmail(): ?string;

    public function setEmail(?string $email);

    public function getPhoneNumber(): ?string;

    public function setPhoneNumber(?string $phoneNumber): void;

    public function getStreet(): ?string;

    public function setStreet(?string $street);

    public function getCity(): ?string;

    public function setCity(?string $city);

    public function getProvince(): ?string;

    public function setProvince(?string $province);

    public function getCountry(): ?string;

    public function setCountry(?string $country);

    public function getPostcode(): ?string;

    public function setPostcode(?string $postcode): void;

    public function getCustomerIp(): ?string;

    public function setCustomerIp(?string $customerIp): void;
}
