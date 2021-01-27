<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfiguration;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;

final class AutomaticBlacklistingConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingConfiguration::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingConfigurationInterface::class);
    }

    function it_has_null_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_name_by_default(): void
    {
        $this->getName()->shouldReturn(null);
    }

    function it_has_add_fraud_suspicion_after_exceed_limit_set_true_by_default(): void
    {
        $this->isAddFraudSuspicionRowAfterExceedLimit()->shouldReturn(true);
    }

    function it_sets_add_fraud_suspicion_after_exceed_limit(): void
    {
        $this->isAddFraudSuspicionRowAfterExceedLimit()->shouldReturn(true);

        $this->setAddFraudSuspicionRowAfterExceedLimit(false);

        $this->isAddFraudSuspicionRowAfterExceedLimit()->shouldReturn(false);
    }

    function it_has_empty_collection_of_channels_by_default(): void
    {
        $this->getChannels()->isEmpty()->shouldReturn(true);
    }

    function it_has_empty_collection_of_rules_by_default(): void
    {
        $this->getRules()->isEmpty()->shouldReturn(true);
    }

    function it_add_rules(AutomaticBlacklistingRuleInterface $automaticBlacklistingRule): void
    {
        $this->hasRule($automaticBlacklistingRule)->shouldReturn(false);

        $this->addRule($automaticBlacklistingRule);

        $this->hasRule($automaticBlacklistingRule)->shouldReturn(true);
    }

    function it_add_channels(ChannelInterface $channel): void
    {
        $this->hasChannel($channel)->shouldReturn(false);

        $this->addChannel($channel);

        $this->hasChannel($channel)->shouldReturn(true);
    }
}
