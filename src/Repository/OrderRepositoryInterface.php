<?php

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

interface OrderRepositoryInterface extends BaseOrderRepositoryInterface
{
    public function findByCustomerPaymentFailuresInCurrentDay(CustomerInterface $customer): string;

    public function findByCustomerOrdersInCurrentWeek(CustomerInterface $customer): string;
}