<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Sylius\Component\Payment\Model\PaymentInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

final class OrderRepository extends BaseOrderRepository implements OrderRepositoryInterface
{
    public function findByCustomerPaymentFailuresAndPeriod(CustomerInterface $customer, \DateTime $date): int
    {
        return $this->createQueryBuilder('o')
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

    public function findByCustomerOrdersInCurrentWeek(CustomerInterface $customer, string $dateModifier): string
    {
        return $this->createQueryBuilder('o')
            ->select(['COUNT(o.id)'])
            ->innerJoin('o.customer', 'customer')
            ->where('customer.id = :customerId')
            ->andWhere('o.createdAt >= :date')
            ->setParameters([
                'customerId' => $customer->getId(),
                'date' => (new \DateTime())->modify('- '. $dateModifier)
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }
}
