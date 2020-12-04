<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

final class OrderRepository extends BaseOrderRepository implements OrderRepositoryInterface
{
    public function findByCustomerPaymentFailuresAndPeriod(CustomerInterface $customer, \DateTime $date): int
    {
        return (int) $this->createQueryBuilder('o')
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
        return (int)$this->createQueryBuilder('o')
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
