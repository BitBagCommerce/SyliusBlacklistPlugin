<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\ProvinceBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

final class ProvinceBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProvinceBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getProvince()->willReturn('California');
        $fraudSuspicionCommonModel->getProvince()->willReturn('California');
        $builder->andWhere('o.province = :province')->willReturn($builder);
        $builder->setParameter('province', 'California')->willReturn($builder);

        $fraudSuspicionCommonModel->getProvince()->shouldBeCalled();
        $fraudSuspicionCommonModel->getProvince()->shouldBeCalled();
        $builder->andWhere('o.province = :province')->shouldBeCalled();
        $builder->setParameter('province', 'California')->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_does_nothing_if_province_is_null(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getProvince()->willReturn(null);

        $fraudSuspicionCommonModel->getProvince()->shouldBeCalled();

        $builder->andWhere('o.province = :province')->shouldNotBeCalled();
        $builder->setParameter('province', 'California')->shouldNotBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(ProvinceBlacklistingRuleChecker::PROVINCE_ATTRIBUTE_NAME);
    }
}
