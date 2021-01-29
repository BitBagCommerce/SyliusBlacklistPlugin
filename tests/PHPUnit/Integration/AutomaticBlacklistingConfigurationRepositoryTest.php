<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\PHPUnit\Integration;

use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

class AutomaticBlacklistingConfigurationRepositoryTest extends IntegrationTestCase
{
    /** @var AutomaticBlacklistingConfigurationRepositoryInterface */
    private $automaticBlacklistingConfigurationRepository;

    /** @var ChannelInterface */
    private $channelRepository;

    public function SetUp(): void
    {
        parent::SetUp();

        $this->automaticBlacklistingConfigurationRepository = self::$container->get('bitbag_sylius_blacklist_plugin.repository.automatic_blacklisting_configuration');
        $this->channelRepository = self::$container->get('sylius.repository.channel');
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_was_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_was_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNull(null);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);
        $this->assertNotEmpty($automaticBlacklistingConfiguration);
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_was_not_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_was_not_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);
        $this->assertEmpty($automaticBlacklistingConfiguration);
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_and_add_fraud_suspicion_was_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_and_add_fraud_suspicion_was_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddFraudSuspicion($channel);
        $this->assertNotEmpty($automaticBlacklistingConfiguration);
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_and_add_fraud_suspicion_was_not_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_and_add_fraud_suspicion_was_not_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddFraudSuspicion($channel);
        $this->assertEmpty($automaticBlacklistingConfiguration);
    }
}