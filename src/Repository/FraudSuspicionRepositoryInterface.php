<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface FraudSuspicionRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    public function createQueryToLaunchBlacklistingRuleCheckers(): QueryBuilder;

    public function findOneByOrder(OrderInterface $order): ?FraudSuspicionInterface;

    public function findOneByOrderNumber(string $orderNumber): ?FraudSuspicionInterface;

    public function countByCustomerAndCommentAndDate(CustomerInterface $customer, string $comment, \DateTime $date): string;
}