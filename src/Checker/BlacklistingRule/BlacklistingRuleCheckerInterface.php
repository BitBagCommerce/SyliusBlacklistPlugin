<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Core\Model\AddressInterface;

interface BlacklistingRuleCheckerInterface
{
    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order, AddressInterface $address): void;

    public function getAttributeName(): string;
}
