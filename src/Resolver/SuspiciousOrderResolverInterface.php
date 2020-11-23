<?php

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use Sylius\Component\Order\Model\OrderInterface;

interface SuspiciousOrderResolverInterface
{
    public function resolve(OrderInterface $order);
}