<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Channel\Model\ChannelInterface;

final class AutomaticBlacklistingConfigurationRepository extends EntityRepository implements AutomaticBlacklistingConfigurationRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('channels')
            ->innerJoin('o.channels', 'channels')
        ;
    }

    public function findActiveByChannel(ChannelInterface $channel): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channel')
            ->where('channel.id = :channelId')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('channelId', $channel->getId())
            ->setParameter('enabled', true)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveByChannelWithAddFraudSuspicion(ChannelInterface $channel): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channel')
            ->where('channel.id = :channelId')
            ->andWhere('o.enabled = :enabled')
            ->andWhere('o.addFraudSuspicion = :addFraudSuspicion')
            ->setParameter('channelId', $channel->getId())
            ->setParameter('enabled', true)
            ->setParameter('addFraudSuspicion', true)
            ->getQuery()
            ->getResult()
        ;
    }
}
