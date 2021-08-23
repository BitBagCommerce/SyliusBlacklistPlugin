<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer\CustomerIpBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

final class CustomerIpBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CustomerIpBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getCustomerIp()->willReturn('192.232.158.3');
        $fraudSuspicionCommonModel->getCustomerIp()->willReturn('192.232.158.3');
        $builder->andWhere('o.customerIp = :customerIp')->willReturn($builder);
        $builder->setParameter('customerIp', '192.232.158.3')->willReturn($builder);

        $fraudSuspicionCommonModel->getCustomerIp()->shouldBeCalled();
        $fraudSuspicionCommonModel->getCustomerIp()->shouldBeCalled();
        $builder->andWhere('o.customerIp = :customerIp')->shouldBeCalled();
        $builder->setParameter('customerIp', '192.232.158.3')->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_does_nothing_if_customer_ip_is_null(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getCustomerIp()->willReturn(null);

        $fraudSuspicionCommonModel->getCustomerIp()->shouldBeCalled();

        $builder->andWhere('o.customerIp = :customerIp')->shouldNotBeCalled();
        $builder->setParameter('customerIp', null)->shouldNotBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(CustomerIpBlacklistingRuleChecker::CUSTOMER_IP_ATTRIBUTE_NAME);
    }
}
