<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer\CustomerIdBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

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

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel, CustomerInterface $customer): void
    {
        $fraudSuspicionCommonModel->getCustomer()->willReturn($customer);
        $customer->getId()->willReturn(1);
        $builder->andWhere('customer.id = :customerId')->willReturn($builder);
        $builder->setParameter('customerId', 1);

        $fraudSuspicionCommonModel->getCustomer()->shouldBeCalled();
        $builder->andWhere('customer.id = :customerId')->shouldBeCalled();
        $builder->setParameter('customerId', 1)->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }


    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(CustomerIdBlacklistingRuleChecker::CUSTOMER_ID_ATTRIBUTE_NAME);
    }
}
