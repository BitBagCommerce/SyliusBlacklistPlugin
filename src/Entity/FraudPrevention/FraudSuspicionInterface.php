<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Resource\Model\ResourceInterface;

interface FraudSuspicionInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function getOrderId(): ?int;

    public function setOrderId(int $orderId);

    public function getCustomerId(): ?int;

    public function setCustomerId(int $customerId);

    public function getCompany(): ?string;

    public function setCompany(string $company);

    public function getFirstName(): ?string;

    public function setFirstName(string $firstName);

    public function getLastName(): ?string;

    public function setLastName(string $lastName);

    public function getEmail(): ?string;

    public function setEmail(string $email);

    public function getStreet(): ?string;

    public function setStreet(string $street);

    public function getCity(): ?string;

    public function setCity(string $city);

    public function getProvince(): ?string;

    public function setProvince(string $province);

    public function getCountry(): ?string;

    public function setCountry(string $country);

    public function getAddressType(): ?string;

    public function setAddressType(string $addressType);
}