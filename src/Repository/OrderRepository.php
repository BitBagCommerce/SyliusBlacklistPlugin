<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Payment\Model\PaymentInterface;

final class OrderRepository implements OrderRepositoryInterface
{
    /** @var BaseOrderRepositoryInterface|EntityRepository */
    private $baseOrderRepository;

    public function __construct(BaseOrderRepositoryInterface $baseOrderRepository)
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
