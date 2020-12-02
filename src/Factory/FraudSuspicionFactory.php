<?php

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
}