<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace spec\BitBag\SyliusBlacklistPlugin\StateResolver;

use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolver;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions;
use Doctrine\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use SM\Factory\FactoryInterface;
use SM\StateMachine\StateMachineInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class CustomerStateResolverSpec extends ObjectBehavior
{
    function let(FactoryInterface $stateMachineFactory, ObjectManager $customerManager): void
    {
        $this->beConstructedWith($stateMachineFactory, $customerManager);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CustomerStateResolver::class);
    }

    function it_implements_automatic_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(CustomerStateResolverInterface::class);
    }

    function it_changes_fraud_status_of_customer(CustomerInterface $customer, FactoryInterface $stateMachineFactory, StateMachineInterface $stateMachine, ObjectManager $customerManager): void
    {
        $stateMachineFactory->get($customer, CustomerTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(CustomerTransitions::TRANSITION_BLACKLISTING_PROCESS)->willReturn(true);

        $stateMachineFactory->get($customer, CustomerTransitions::GRAPH)->shouldBeCalled();
        $stateMachine->can(CustomerTransitions::TRANSITION_BLACKLISTING_PROCESS)->shouldBeCalled();
        $stateMachine->apply(CustomerTransitions::TRANSITION_BLACKLISTING_PROCESS)->shouldBeCalled();
        $customerManager->persist($customer)->shouldBeCalled();
        $customerManager->flush()->shouldBeCalled();

        $this->changeStateOnBlacklisted($customer);
    }
}
