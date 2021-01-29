<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface AutomaticBlacklistingConfigurationRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    public function findActiveByChannel(ChannelInterface $channel): array;

    public function findActiveByChannelWithAddFraudSuspicion(ChannelInterface $channel): array;
}