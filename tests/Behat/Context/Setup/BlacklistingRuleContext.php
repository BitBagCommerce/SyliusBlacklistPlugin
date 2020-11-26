<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Service\RandomStringGeneratorInterface;

final class BlacklistingRuleContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var RandomStringGeneratorInterface */
    private $randomStringGenerator;

    /** @var FactoryInterface */
    private $blacklistingFactory;

    /** @var RepositoryInterface */
    private $blacklistingRuleRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $blacklistingFactory,
        RepositoryInterface $blacklistingRuleRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->blacklistingFactory = $blacklistingFactory;
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
    }

    private function createBlock(
        ?string $name = null,
        ?string $permittedStrikes = null,
        ChannelInterface $channel = null
    ): BlacklistingRuleInterface
    {
        /** @var BlacklistingRuleInterface $blacklistingRule */
        $blacklistingRule = $this->blacklistingFactory->createNew();

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

        if (null === $name) {
            $name = $this->randomStringGenerator->generate();
        }

        if (null === $permittedStrikes) {
            $permittedStrikes = \rand(1, 10);
        }

        $blacklistingRule->setName($name);
        $blacklistingRule->setPermittedStrikes($permittedStrikes);
        $blacklistingRule->addChannel($channel);

        return $blacklistingRule;
    }

    private function saveBlacklistingRule(BlacklistingRuleInterface $blacklistingRule): void
    {
        $this->blacklistingRuleRepository->add($blacklistingRule);
        $this->sharedStorage->set('blacklistingRule', $blacklistingRule);
    }
}
