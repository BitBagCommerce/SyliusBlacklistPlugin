<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
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

    public function setCompany(?string $company): void;

    public function getFirstName(): ?string;

    public function setFirstName(?string $firstName): void;

    public function getLastName(): ?string;

    public function setLastName(?string $lastName): void;

    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    public function getPhoneNumber(): ?string;

    public function setPhoneNumber(?string $phoneNumber): void;

    public function getStreet(): ?string;

    public function setStreet(?string $street): void;

    public function getCity(): ?string;

    public function setCity(?string $city): void;

    public function getProvince(): ?string;

    public function setProvince(?string $province): void;

    public function getCountry(): ?string;

    public function setCountry(?string $country): void;

    public function getPostcode(): ?string;

    public function setPostcode(?string $postcode): void;

    public function getCustomerIp(): ?string;

    public function setCustomerIp(?string $customerIp): void;

    public function getAddressType(): ?string;

    public function setAddressType(string $addressType): void;

    public function getComment(): ?string;

    public function setComment(?string $comment): void;

    public function getStatus(): ?string;

    public function setStatus(?string $status): void;
}
