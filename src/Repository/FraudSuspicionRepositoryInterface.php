<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
