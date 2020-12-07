<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\LastNameBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use PhpSpec\ObjectBehavior;

final class LastNameBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(LastNameBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(LastNameBlacklistingRuleChecker::LAST_NAME_ATTRIBUTE_NAME);
    }
}
