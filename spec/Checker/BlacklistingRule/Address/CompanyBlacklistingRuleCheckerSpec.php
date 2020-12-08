<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\CompanyBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

final class CompanyBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CompanyBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getCompany()->willReturn('Google');
        $fraudSuspicionCommonModel->getCompany()->willReturn('Google');
        $builder->andWhere('o.company = :company')->willReturn($builder);
        $builder->setParameter('company', 'Google')->willReturn($builder);

        $fraudSuspicionCommonModel->getCompany()->shouldBeCalled();
        $fraudSuspicionCommonModel->getCompany()->shouldBeCalled();
        $builder->andWhere('o.company = :company')->shouldBeCalled();
        $builder->setParameter('company', 'Google')->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_does_nothing_if_company_is_null(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getCompany()->willReturn(null);

        $fraudSuspicionCommonModel->getCompany()->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(CompanyBlacklistingRuleChecker::COMPANY_ATTRIBUTE_NAME);
    }
}
