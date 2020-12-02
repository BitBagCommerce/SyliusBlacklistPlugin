<?php

namespace BitBag\SyliusBlacklistPlugin\Converter;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Sylius\Component\Order\Model\OrderInterface;

interface FraudSuspicionCommonModelConverterInterface
{
    public function convertFraudSuspicionObject(FraudSuspicionInterface $fraudSuspicion): FraudSuspicionCommonModelInterface;

    public function convertOrderObject(OrderInterface $order, string $addressType): FraudSuspicionCommonModelInterface;
}