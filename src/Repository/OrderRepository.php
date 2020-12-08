<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;

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
