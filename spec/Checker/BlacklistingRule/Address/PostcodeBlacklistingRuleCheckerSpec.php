<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\PostcodeBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;
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

    function it_adds_part_of_query(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $fraudSuspicionCommonModel->getPostcode()->willReturn('95263');
        $builder->andWhere('o.postcode = :postcode')->willReturn($builder);
        $builder->setParameter('postcode', '95263')->willReturn($builder);

        $fraudSuspicionCommonModel->getPostcode()->shouldBeCalled();
        $builder->andWhere('o.postcode = :postcode')->shouldBeCalled();
        $builder->setParameter('postcode', '95263')->shouldBeCalled();

        $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    function it_gets_attribute_name(): void
    {
        $this->getAttributeName()->shouldReturn(PostcodeBlacklistingRuleChecker::POSTCODE_ATTRIBUTE_NAME);
    }
}
