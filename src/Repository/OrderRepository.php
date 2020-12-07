<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class OrderRepository implements OrderRepositoryInterface
{
    /** @var EntityRepository */
    private $baseOrderRepository;

    public function __construct(EntityRepository $baseOrderRepository)
    {
        $this->baseOrderRepository = $baseOrderRepository;
    }

    public function findByCustomerPaymentFailuresAndPeriod(CustomerInterface $customer, \DateTime $date): int
    {
        return (int) $this->baseOrderRepository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->innerJoin('o.customer', 'customer')
            ->where('customer.id = :customerId')
            ->andWhere('o.paymentState = :failedState')
            ->andWhere('o.createdAt >= :date')
            ->setParameter('customerId', $customer->getId())
            ->setParameter('failedState', PaymentInterface::STATE_FAILED)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findPlacedOrdersByCustomerAndPeriod(CustomerInterface $customer, \DateTime $date): int
    {
        return (int) $this->baseOrderRepository->createQueryBuilder('o')
            ->select(['COUNT(o.id)'])
            ->innerJoin('o.customer', 'customer')
            ->where('customer.id = :customerId')
            ->andWhere('o.createdAt >= :date')
            ->andWhere('o.state != :cartState')
            ->setParameter('customerId', $customer->getId())
            ->setParameter('date', $date)
            ->setParameter('cartState', OrderInterface::STATE_CART)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
