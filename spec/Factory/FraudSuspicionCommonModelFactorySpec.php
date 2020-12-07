<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionCommonModelFactory;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionCommonModelFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use PhpSpec\ObjectBehavior;

final class FraudSuspicionCommonModelFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelFactory::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelFactoryInterface::class);
    }

    function it_creates_empty_fraud_suspicion_common_model_object(): void
    {
        $this->createNew()->shouldBeAnInstanceOf(FraudSuspicionCommonModel::class);
    }
}
