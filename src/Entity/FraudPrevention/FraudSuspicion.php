<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Order\Model\OrderInterface;

class FraudSuspicion implements FraudSuspicionInterface
{
    /** @var int|null */
    protected $id;

    /** @var OrderInterface|null */
    protected $order;

    /** @var int|null */
    protected $customerId;

    /** @var string|null */
    protected $company;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $email;

    /** @var string */
    protected $street;

    /** @var string */
    protected $city;

    /** @var string */
    protected $province;

    /** @var string */
    protected $country;

    /** @var string */
    protected $addressType;

    /** @var string|null */
    protected $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company)
    {
        $this->company = $company;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province)
    {
        $this->province = $province;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    public function getAddressType(): ?string
    {
        return $this->addressType;
    }

    public function setAddressType(string $addressType)
    {
        $this->addressType = $addressType;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }
}
