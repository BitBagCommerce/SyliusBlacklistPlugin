<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

        $this->automaticBlacklistingConfigurationRepository = self::getContainer()->get('bitbag_sylius_blacklist_plugin.repository.automatic_blacklisting_configuration');
        $this->channelRepository = self::getContainer()->get('sylius.repository.channel');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        self::ensureKernelShutdown();
    }

    public function test_active_automatic_blacklisting_configurations_by_channel_were_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configurations_by_channel_were_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfigurations = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);
        $this->assertNotEmpty($automaticBlacklistingConfigurations);
        $this->assertEquals(2, \count($automaticBlacklistingConfigurations));
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_was_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_was_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);
        $this->assertNotEmpty($automaticBlacklistingConfiguration);
        $this->assertEquals(1, \count($automaticBlacklistingConfiguration));
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_was_not_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_was_not_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);
        $this->assertEmpty($automaticBlacklistingConfiguration);
    }

    public function test_active_automatic_blacklisting_configurations_by_channel_and_add_fraud_suspicion_were_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configurations_by_channel_and_add_fraud_suspicion_were_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfigurations = $this->automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddFraudSuspicion($channel);
        $this->assertNotEmpty($automaticBlacklistingConfigurations);
        $this->assertEquals(2, \count($automaticBlacklistingConfigurations));
    }

    public function test_active_automatic_blacklisting_configuration_by_channel_and_add_fraud_suspicion_was_found(): void
    {
        $this->loadFixturesFromFiles(['test_active_automatic_blacklisting_configuration_by_channel_and_add_fraud_suspicion_was_found.yaml']);

        $channel = $this->channelRepository->findOneByCode('FASHION_WEB_STORE');
        $this->assertNotNull($channel);

        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddFraudSuspicion($channel);
        $this->assertNotEmpty($automaticBlacklistingConfiguration);
        $this->assertEquals(1, \count($automaticBlacklistingConfiguration));
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
