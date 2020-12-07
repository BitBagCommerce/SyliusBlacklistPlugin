<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer\CustomerIdBlacklistingRuleChecker;
use PhpSpec\ObjectBehavior;

final class CustomerIdBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CustomerIdBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(CustomerIdBlacklistingRuleChecker::CUSTOMER_ID_ATTRIBUTE_NAME);
    }
}
