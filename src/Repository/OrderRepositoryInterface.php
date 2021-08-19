<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Repository;

use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

interface OrderRepositoryInterface
{
    public function findByCustomerPaymentFailuresAndPeriod(CustomerInterface $customer, \DateTime $date): int;

    public function findPlacedOrdersByCustomerAndPeriod(CustomerInterface $customer, \DateTime $date): int;
}
