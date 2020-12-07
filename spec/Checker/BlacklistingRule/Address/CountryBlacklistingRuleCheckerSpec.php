<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\CountryBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use PhpSpec\ObjectBehavior;

final class CountryBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CountryBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(CountryBlacklistingRuleChecker::COUNTRY_ATTRIBUTE_NAME);
    }
}
