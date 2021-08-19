<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Repository;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class FraudSuspicionRepository extends EntityRepository implements FraudSuspicionRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('customer')
            ->addSelect('ord')
            ->leftJoin('o.order', 'ord')
            ->leftJoin('o.customer', 'customer')
        ;
    }

    public function createQueryToLaunchBlacklistingRuleCheckers(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->leftJoin('o.order', 'ord')
            ->leftJoin('o.customer', 'customer')
        ;
    }

    public function findOneByOrder(OrderInterface $order): ?FraudSuspicionInterface
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.order', 'ord')
            ->andWhere('ord.id = :orderId')
            ->setParameter('orderId', $order->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByOrderNumber(string $orderNumber): ?FraudSuspicionInterface
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.order', 'ord')
            ->andWhere('ord.number = :orderNumber')
            ->setParameter('orderNumber', $orderNumber)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function countByCustomerAndCommentAndDate(CustomerInterface $customer, string $status, \DateTime $date): string
    {
        return $this->createQueryBuilder('o')
            ->select(['COUNT(o.id)'])
            ->innerJoin('o.customer', 'customer')
            ->andWhere('customer = :customer')
            ->andWhere('o.status = :comment')
            ->andWhere('o.createdAt >= :date')
            ->setParameter('customer', $customer)
            ->setParameter('comment', $status)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
