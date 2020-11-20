<?php

namespace BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface FraudSuspicionFactoryInterface extends FactoryInterface
{
    public function createNew(): FraudSuspicionInterface;

    public function createForOrder(OrderInterface $order): FraudSuspicionInterface;
}

