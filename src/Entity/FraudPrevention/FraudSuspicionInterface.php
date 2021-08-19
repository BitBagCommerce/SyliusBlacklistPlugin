<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface FraudSuspicionInterface extends ResourceInterface, TimestampableInterface
{
    /** @var string */
    public const BILLING_ADDRESS_TYPE = 'billing';

    /** @var string */
    public const SHIPPING_ADDRESS_TYPE = 'shipping';

    /** @var string */
    public const AUTO_GENERATED_STATUS = 'auto-generated';

    /** @var string */
    public const MANUALLY_ADDED_STATUS = 'manually-added';

    public function getId(): ?int;

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

    public function setPhoneNumber(?string $phoneNumber);

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

    public function getAddressType(): ?string;

    public function setAddressType(string $addressType);

    public function getComment(): ?string;

    public function setComment(?string $comment): void;

    public function getStatus(): ?string;

    public function setStatus(?string $status): void;
}
