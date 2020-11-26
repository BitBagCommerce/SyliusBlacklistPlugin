<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Channel\Model\ChannelInterface;

final class BlacklistingRuleRepository extends EntityRepository implements BlacklistingRuleRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o');
    }

    public function findByChannel(ChannelInterface $channel): array
    {
        return $this->createListQueryBuilder()
            ->innerJoin('o.channels', 'channel')
            ->where('channel.id = :channelId')
            ->setParameter('channelId', $channel->getId())
            ->getQuery()
            ->getResult();
    }
}
