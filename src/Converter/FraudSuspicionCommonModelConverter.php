<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Converter;

use BitBag\SyliusBlacklistPlugin\Dto\FraudSuspicionCommonDTO;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Exception\WrongAddressTypeException;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionCommonModelFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class FraudSuspicionCommonModelConverter implements FraudSuspicionCommonModelConverterInterface
{
    public function __construct(
        private readonly FraudSuspicionCommonModelFactoryInterface $fraudSuspicionCommonModelFactory,
    ) {
    }

    public function convertFraudSuspicionObject(FraudSuspicionInterface $fraudSuspicion): FraudSuspicionCommonModelInterface
    {
        $dto = new FraudSuspicionCommonDTO(
            order: $fraudSuspicion->getOrder(),
            customer: $fraudSuspicion->getCustomer(),
            company: $fraudSuspicion->getCompany(),
            firstName: $fraudSuspicion->getFirstName(),
            lastName: $fraudSuspicion->getLastName(),
            email: $fraudSuspicion->getEmail(),
            phoneNumber: $fraudSuspicion->getPhoneNumber(),
            street: $fraudSuspicion->getStreet(),
            city: $fraudSuspicion->getCity(),
            province: $fraudSuspicion->getProvince(),
            country: $fraudSuspicion->getCountry(),
            postcode: $fraudSuspicion->getPostcode(),
            customerIp: $fraudSuspicion->getCustomerIp(),
        );

        return $this->populateFraudSuspicionCommonModel(
            $this->fraudSuspicionCommonModelFactory->createNew(),
            $dto,
        );
    }

    public function convertOrderObject(OrderInterface $order, string $addressType): FraudSuspicionCommonModelInterface
    {
        $address = $this->getAddressFromOrder($order, $addressType);

        $dto = new FraudSuspicionCommonDTO(
            order: $order,
            customer: $order->getCustomer(),
            company: $address?->getCompany() ?? '',
            firstName: $address?->getFirstName() ?? '',
            lastName: $address?->getLastName() ?? '',
            email: $order->getCustomer()?->getEmail() ?? '',
            phoneNumber: $address?->getPhoneNumber() ?? '',
            street: $address?->getStreet() ?? '',
            city: $address?->getCity() ?? '',
            province: $address?->getProvinceName() ?? '',
            country: $address?->getCountryCode() ?? '',
            postcode: $address?->getPostcode() ?? '',
            customerIp: $order->getCustomerIp() ?? '',
        );

        return $this->populateFraudSuspicionCommonModel(
            $this->fraudSuspicionCommonModelFactory->createNew(),
            $dto,
        );
    }

    private function getAddressFromOrder(OrderInterface $order, string $addressType): ?AddressInterface
    {
        return match ($addressType) {
            FraudSuspicion::BILLING_ADDRESS_TYPE => $order->getBillingAddress(),
            FraudSuspicion::SHIPPING_ADDRESS_TYPE => $order->getShippingAddress(),
            default => throw new WrongAddressTypeException('Wrong address type!'),
        };
    }

    private function populateFraudSuspicionCommonModel(
        FraudSuspicionCommonModelInterface $model,
        FraudSuspicionCommonDTO $dto,
    ): FraudSuspicionCommonModelInterface {
        $model->setOrder($dto->order);
        $model->setCustomer($dto->customer);
        $model->setCompany($dto->company);
        $model->setFirstName($dto->firstName);
        $model->setLastName($dto->lastName);
        $model->setEmail($dto->email);
        $model->setPhoneNumber($dto->phoneNumber);
        $model->setStreet($dto->street);
        $model->setCity($dto->city);
        $model->setProvince($dto->province);
        $model->setCountry($dto->country);
        $model->setPostcode($dto->postcode);
        $model->setCustomerIp($dto->customerIp);

        return $model;
    }
}
