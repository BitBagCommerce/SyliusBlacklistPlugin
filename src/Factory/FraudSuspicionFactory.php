<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Component\Core\Model\OrderInterface;

class FraudSuspicionFactory implements FraudSuspicionFactoryInterface
{
    public function createNew(): FraudSuspicionInterface
    {
        return new FraudSuspicion();
    }

    public function createForOrder(OrderInterface $order): FraudSuspicionInterface
    {
        $fraudSuspicion = $this->createNew();

        $fraudSuspicion->setOrder($order);
        $fraudSuspicion->setCustomer($order->getCustomer());
        $fraudSuspicion->setCompany($order->getBillingAddress()->getCompany());
        $fraudSuspicion->setFirstName($order->getBillingAddress()->getFirstName());
        $fraudSuspicion->setLastName($order->getBillingAddress()->getLastName());
        $fraudSuspicion->setEmail($order->getCustomer()->getEmail());
        $fraudSuspicion->setStreet($order->getBillingAddress()->getStreet());
        $fraudSuspicion->setCity($order->getBillingAddress()->getCity());
        $fraudSuspicion->setProvince($order->getBillingAddress()->getProvinceName());
        $fraudSuspicion->setCountry($order->getBillingAddress()->getCountryCode());
        $fraudSuspicion->setPostcode($order->getBillingAddress()->getPostcode());
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