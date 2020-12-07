<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer\EmailBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

final class EmailBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmailBlacklistingRuleChecker::class);
    }

    function it_implements_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleCheckerInterface::class);
    }

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModel $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getEmail()->willReturn('john_doe@example.com');
        $builder->andWhere('o.email = :email')->willReturn($builder);
        $builder->setParameter('email', 'john_doe@example.com')->willReturn($builder);

        $fraudSuspicionCommonModel->getEmail()->shouldBeCalled();
        $builder->andWhere('o.email = :email')->shouldBeCalled();
        $builder->setParameter('email', 'john_doe@example.com')->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(EmailBlacklistingRuleChecker::EMAIL_ATTRIBUTE_NAME);
    }
}
