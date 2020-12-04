<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Model;

use Sylius\Component\Order\Model\OrderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

class FraudSuspicionCommonModel implements FraudSuspicionCommonModelInterface
{
    /** @var OrderInterface|null */
    protected $order;

    /** @var CustomerInterface */
    protected $customer;

    /** @var string|null */
    protected $company;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $email;

    /** @var string */
    protected $phoneNumber;

    /** @var string */
    protected $street;

    /** @var string */
    protected $city;

    /** @var string */
    protected $province;

    /** @var string */
    protected $country;

    /** @var string|null */
    protected $postcode;

    /** @var string|null */
    protected $customerIp;

    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer(CustomerInterface $customer): void
    {
        $this->customer = $customer;
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
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

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function getCustomerIp(): ?string
    {
        return $this->customerIp;
    }

    public function setCustomerIp(?string $customerIp): void
    {
        $this->customerIp = $customerIp;
    }
}
