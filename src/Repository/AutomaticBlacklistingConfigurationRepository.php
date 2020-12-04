<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

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
}
