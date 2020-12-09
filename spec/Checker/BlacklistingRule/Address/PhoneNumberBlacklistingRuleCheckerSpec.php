<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\PhoneNumberBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

final class PhoneNumberBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PhoneNumberBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getPhoneNumber()->willReturn('567234853');
        $fraudSuspicionCommonModel->getPhoneNumber()->willReturn('567234853');
        $builder->andWhere('o.phoneNumber = :phoneNumber')->willReturn($builder);
        $builder->setParameter('phoneNumber', '567234853')->willReturn($builder);

        $fraudSuspicionCommonModel->getPhoneNumber()->shouldBeCalled();
        $fraudSuspicionCommonModel->getPhoneNumber()->shouldBeCalled();
        $builder->andWhere('o.phoneNumber = :phoneNumber')->shouldBeCalled();
        $builder->setParameter('phoneNumber', '567234853')->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_does_nothing_if_phone_number_is_null(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getPhoneNumber()->willReturn(null);

        $fraudSuspicionCommonModel->getPhoneNumber()->shouldBeCalled();
        $builder->andWhere('o.phoneNumber = :phoneNumber')->shouldNotBeCalled();
        $builder->setParameter('phoneNumber', null)->shouldNotBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

        function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(PhoneNumberBlacklistingRuleChecker::PHONE_NUMBER_ATTRIBUTE_NAME);
    }
}
