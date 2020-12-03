<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\AutomaticBlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\OrdersAutomaticBlacklistingRuleChecker;
use PhpSpec\ObjectBehavior;

final class OrdersAutomaticBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(OrdersAutomaticBlacklistingRuleChecker::class);
    }

    function it_implements_automatic_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingRuleCheckerInterface::class);
    }

    function it_gets_type(): void {
        $this->getType()->shouldReturn(OrdersAutomaticBlacklistingRuleChecker::TYPE);
    }
}
