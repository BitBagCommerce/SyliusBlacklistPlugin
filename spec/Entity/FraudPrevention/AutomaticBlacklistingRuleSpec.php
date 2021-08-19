<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfiguration;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRule;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use PhpSpec\ObjectBehavior;

final class AutomaticBlacklistingRuleSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingRule::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingRuleInterface::class);
    }

    function it_has_null_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_type_by_default(): void
    {
        $this->getType()->shouldReturn(null);
    }

    function it_has_empty_settings_by_default(): void
    {
        $this->getSettings()->shouldReturn([]);
    }

    function it_has_no_configuration_by_default(): void
    {
        $this->getConfiguration()->shouldReturn(null);
    }

    function it_gets_configuration(AutomaticBlacklistingConfiguration $automaticBlacklistingConfiguration): void
    {
        $this->setConfiguration($automaticBlacklistingConfiguration);

        $this->getConfiguration()->shouldReturn($automaticBlacklistingConfiguration);
    }
}
