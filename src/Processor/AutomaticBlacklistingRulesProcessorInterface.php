<?php

namespace BitBag\SyliusBlacklistPlugin\Processor;

use Sylius\Component\Order\Model\OrderInterface;

interface AutomaticBlacklistingRulesProcessorInterface
{
    public function process(OrderInterface $order): bool;
}