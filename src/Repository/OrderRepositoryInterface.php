<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

interface OrderRepositoryInterface extends BaseOrderRepositoryInterface
{
    public function findByCustomerPaymentFailuresAndPeriod(CustomerInterface $customer, \DateTime $date): int;

    public function findByCustomerOrdersInCurrentWeek(CustomerInterface $customer, string $dateModifier): string;
}