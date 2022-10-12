<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class FraudSuspicionRepository implements FraudSuspicionRepositoryInterface
{
    private EntityRepository $decoratedRepository;

    public function __construct(EntityRepository $decoratedRepository)
    {
        $this->decoratedRepository = $decoratedRepository;
    }

    public function createQueryBuilder($alias, $indexBy = null): QueryBuilder
    {
        return $this->decoratedRepository->createQueryBuilder($alias, $indexBy);
    }

    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->decoratedRepository->createQueryBuilder('o')
            ->addSelect('customer')
            ->addSelect('ord')
            ->leftJoin('o.order', 'ord')
            ->leftJoin('o.customer', 'customer')
        ;
    }

    public function createQueryToLaunchBlacklistingRuleCheckers(): QueryBuilder
    {
        return $this->decoratedRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->leftJoin('o.order', 'ord')
            ->leftJoin('o.customer', 'customer')
        ;
    }

    public function findOneByOrder(OrderInterface $order): ?FraudSuspicionInterface
    {
        return $this->decoratedRepository->createQueryBuilder('o')
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
        return $this->decoratedRepository->createQueryBuilder('o')
            ->innerJoin('o.order', 'ord')
            ->andWhere('ord.number = :orderNumber')
            ->setParameter('orderNumber', $orderNumber)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function countByCustomerAndCommentAndDate(
        CustomerInterface $customer,
        string $status,
        \DateTime $date
    ): string {
        return $this->decoratedRepository->createQueryBuilder('o')
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

    public function find($id)
    {
        return $this->decoratedRepository->find($id);
    }

    public function findAll()
    {
        return $this->decoratedRepository->findAll();
    }

    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        $limit = null,
        $offset = null
    ) {
        return $this->decoratedRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria)
    {
        return $this->decoratedRepository->findOneBy($criteria);
    }

    public function getClassName()
    {
        return $this->decoratedRepository->getClassName();
    }

    public function createPaginator(array $criteria = [], array $sorting = []): iterable
    {
        return $this->decoratedRepository->createPaginator($criteria, $sorting);
    }

    public function add(ResourceInterface $resource): void
    {
        $this->decoratedRepository->add($resource);
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->decoratedRepository->remove($resource);
    }
}
