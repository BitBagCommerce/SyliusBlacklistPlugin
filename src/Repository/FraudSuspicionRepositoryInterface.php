<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface FraudSuspicionRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    public function findOneByOrder(OrderInterface $order): ?FraudSuspicionInterface;

    public function findOneByOrderNumber(string $orderNumber): ?FraudSuspicionInterface;
}