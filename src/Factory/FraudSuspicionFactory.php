<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class FraudSuspicionFactory implements FraudSuspicionFactoryInterface
{
    public function __construct(
        private readonly FactoryInterface $decoratedFactory,
    ) {
    }

    public function createNew(): FraudSuspicionInterface
    {
        return $this->decoratedFactory->createNew();
    }

    public function createForOrder(OrderInterface $order): FraudSuspicionInterface
    {
        $fraudSuspicion = $this->createNew();
        $billingAddress = $order->getBillingAddress();
        $customer = $order->getCustomer();

        $fraudSuspicion->setOrder($order);
        $fraudSuspicion->setCustomer($customer);
        $fraudSuspicion->setCompany($billingAddress->getCompany());
        $fraudSuspicion->setFirstName($billingAddress->getFirstName());
        $fraudSuspicion->setLastName($billingAddress->getLastName());
        $fraudSuspicion->setEmail($customer?->getEmail());
        $fraudSuspicion->setStreet($billingAddress->getStreet());
        $fraudSuspicion->setCity($billingAddress->getCity());
        $fraudSuspicion->setProvince($billingAddress->getProvinceName() ?? $billingAddress->getProvinceCode());
        $fraudSuspicion->setCountry($billingAddress->getCountryCode());
        $fraudSuspicion->setPostcode($billingAddress->getPostcode());
        $fraudSuspicion->setCustomerIp($order->getCustomerIp());

        return $fraudSuspicion;
    }

    public function createForAutomaticBlacklistingConfiguration(OrderInterface $order): FraudSuspicionInterface
    {
        $fraudSuspicion = $this->createForOrder($order);

        $fraudSuspicion->setAddressType(FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE);
        $fraudSuspicion->setStatus(FraudSuspicionInterface::AUTO_GENERATED_STATUS);

        if (null === $fraudSuspicion->getCustomerIp()) {
            $fraudSuspicion->setCustomerIp($_SERVER['REMOTE_ADDR'] ?? '');
        }

        return $fraudSuspicion;
    }
}
