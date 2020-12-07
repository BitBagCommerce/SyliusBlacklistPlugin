<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\PostcodeBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use PhpSpec\ObjectBehavior;

final class PostcodeBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PostcodeBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(PostcodeBlacklistingRuleChecker::POSTCODE_ATTRIBUTE_NAME);
    }
}
