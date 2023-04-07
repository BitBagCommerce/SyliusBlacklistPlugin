<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class FraudSuspicionFactory implements FraudSuspicionFactoryInterface
{
    private FactoryInterface $decoratedFactory;

    public function __construct(FactoryInterface $decoratedFactory)
    {
        $this->decoratedFactory = $decoratedFactory;
    }

    /**
     * @return object
     */
    public function createNew()
    {
        return $this->decoratedFactory->createNew();
    }

    public function createForOrder(OrderInterface $order): FraudSuspicionInterface
    {
        /** @var FraudSuspicionInterface $fraudSuspicion */
        $fraudSuspicion = $this->createNew();
        $billingAddress = $order->getBillingAddress();

        $fraudSuspicion->setOrder($order);
        $fraudSuspicion->setCustomer($order->getCustomer());
        $fraudSuspicion->setCompany($billingAddress->getCompany());
        $fraudSuspicion->setFirstName($billingAddress->getFirstName());
        $fraudSuspicion->setLastName($billingAddress->getLastName());
        $fraudSuspicion->setEmail($order->getCustomer()->getEmail());
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
            $fraudSuspicion->setCustomerIp($_SERVER['REMOTE_ADDR']);
        }

        return $fraudSuspicion;
    }
}
