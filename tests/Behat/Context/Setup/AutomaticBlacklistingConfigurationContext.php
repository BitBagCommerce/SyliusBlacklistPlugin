<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class AutomaticBlacklistingConfigurationContext implements Context
{
    /** @var FactoryInterface */
    private FactoryInterface $automaticBlacklistingConfigurationFactory;

    /** @var FactoryInterface */
    private FactoryInterface $automaticBlacklistingRuleFactory;

    /** @var SharedStorageInterface */
    private SharedStorageInterface $sharedStorage;

    /** @var ObjectManager */
    private ObjectManager $objectManager;

    public function __construct(
        FactoryInterface $automaticBlacklistingConfigurationFactory,
        FactoryInterface $automaticBlacklistingRuleFactory,
        SharedStorageInterface $sharedStorage,
        ObjectManager $objectManager
    ) {
        $this->automaticBlacklistingConfigurationFactory = $automaticBlacklistingConfigurationFactory;
        $this->automaticBlacklistingRuleFactory = $automaticBlacklistingRuleFactory;
        $this->sharedStorage = $sharedStorage;
        $this->objectManager = $objectManager;
    }

    /**
     * @Given there is a automatic blacklisting configuration :name with rule :type configured with count :count and date modifier :dateModifier
     */
    public function thereIsAAutomaticBlacklistingConfigurationWithRuleConfiguredWithCountAndDateModifier(
        string $name,
        string $type,
        string $count,
        string $dateModifier
    ): void {
        $automaticBlacklistingConfiguration = $this->createAutomaticBlacklistingConfiguration($name);
        /** @var AutomaticBlacklistingRuleInterface $rule */
        $rule = $this->automaticBlacklistingRuleFactory->createNew();
        $rule->setType($type);
        $rule->setSettings(['count' => \intval($count), 'date_modifier' => $dateModifier]);
        $automaticBlacklistingConfiguration->addRule($rule);

        $this->objectManager->persist($automaticBlacklistingConfiguration);
        $this->objectManager->persist($rule);
        $this->objectManager->flush();
    }

    private function createAutomaticBlacklistingConfiguration(string $name): AutomaticBlacklistingConfigurationInterface
    {
        /** @var AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration */
        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationFactory->createNew();

        $channel = $this->sharedStorage->get('channel');

        $automaticBlacklistingConfiguration->setName($name);
        $automaticBlacklistingConfiguration->addChannel($channel);
        $automaticBlacklistingConfiguration->enable();

        return $automaticBlacklistingConfiguration;
    }
}
