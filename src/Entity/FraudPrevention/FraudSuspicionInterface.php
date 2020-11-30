<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

interface FraudSuspicionInterface extends ResourceInterface
{
    /** @var string */
    public const BILLING_ADDRESS_TYPE = 'billing';

    /** @var string */
    public const SHIPPING_ADDRESS_TYPE = 'shipping';

    public function getId(): ?int;

    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order): void;

    public function getCustomer(): ?CustomerInterface;

    public function setCustomer(CustomerInterface $customer): void;

    public function getCompany(): ?string;

    public function setCompany(?string $company);

    public function getFirstName(): ?string;

    public function setFirstName(string $firstName);

    public function getLastName(): ?string;

    public function setLastName(string $lastName);

    public function getEmail(): ?string;

    public function setEmail(string $email);

    public function getPhoneNumber(): ?string;

    public function setPhoneNumber(?string $phoneNumber): self;

    public function getStreet(): ?string;

    public function setStreet(string $street);

    public function getCity(): ?string;

    public function setCity(string $city);

    public function getProvince(): ?string;

    public function setProvince(?string $province);

    public function getCountry(): ?string;

    public function setCountry(string $country);

    public function getAddressType(): ?string;

    public function setAddressType(string $addressType);

    public function getComment(): ?string;

    public function setComment(string $comment): void;
}