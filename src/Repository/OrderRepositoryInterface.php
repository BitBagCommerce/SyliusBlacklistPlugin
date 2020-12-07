<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

interface OrderRepositoryInterface
{
    public function findByCustomerPaymentFailuresAndPeriod(CustomerInterface $customer, \DateTime $date): int;

    public function findPlacedOrdersByCustomerAndPeriod(CustomerInterface $customer, \DateTime $date): int;
}