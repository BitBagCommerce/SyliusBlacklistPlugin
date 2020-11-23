<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;

final class FraudSuspicionRepository extends EntityRepository implements FraudSuspicionRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->select(['COUNT(o.id)'])
            ->innerJoin('o.order', 'ord');
    }

    public function findOneByOrder(OrderInterface $order): ?FraudSuspicionInterface
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.order', 'ord')
            ->andWhere('ord.id = :orderId')
            ->setParameter('orderId', $order->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
