<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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

    /**
     * @Given there is a blacklisting rule in the store
     */
    public function thereIsABlacklistingRuleInTheStore(): void
    {
        $blacklistingRule = $this->createBlacklistingRule();

        $this->saveBlacklistingRule($blacklistingRule);
    }

    /**
     * @Given there is a blacklisting rule with :ruleName name and :permittedStrikes permitted strikes
     * @Given there is a blacklisting rule with :ruleName name and :permittedStrikes permitted strikes and :ruleAttributes as a rule attributes
     */
    public function thereIsABlacklistingRuleWithNameAndPermittedStrikes(string $ruleName, string $permittedStrikes, string $ruleAttributes = null): void
    {
        if ($ruleAttributes !== null) {
            $attributes = explode(', ', $ruleAttributes);

            $blacklistingRule = $this->createBlacklistingRule($ruleName, \intval($permittedStrikes), $attributes);
        } else {
            $blacklistingRule = $this->createBlacklistingRule($ruleName, \intval($permittedStrikes));
        }

        $this->saveBlacklistingRule($blacklistingRule);
    }

    private function createBlacklistingRule(
        ?string $name = null,
        ?int $permittedStrikes = null,
        array $attributes = [],
        ChannelInterface $channel = null
    ): BlacklistingRuleInterface {
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

        foreach ($attributes as $attribute) {
            $blacklistingRule->addAttribute($attribute);
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
