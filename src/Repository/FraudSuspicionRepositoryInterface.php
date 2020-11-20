<?php

namespace BitBag\SyliusBlacklistPlugin\Repository;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\OrderInterface;

interface FraudSuspicionRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    public function findOneByOrder(OrderInterface $order): ?FraudSuspicionInterface;
}