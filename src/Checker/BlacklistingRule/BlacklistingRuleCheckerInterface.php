<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

interface BlacklistingRuleCheckerInterface
{
    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void;

    public function getAttributeName(): string;
}
