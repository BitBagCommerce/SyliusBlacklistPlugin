<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\StateResolver;

use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolver;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Doctrine\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

final class CustomerStateResolverSpec extends ObjectBehavior
{
    function let(WorkflowInterface $workflow, ObjectManager $customerManager): void
    {
        $this->beConstructedWith($workflow, $customerManager);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CustomerStateResolver::class);
    }

    function it_implements_customer_state_resolver_interface(): void
    {
        $this->shouldImplement(CustomerStateResolverInterface::class);
    }

    function it_changes_state_on_blacklisted(
        WorkflowInterface $workflow,
        ObjectManager $customerManager,
        CustomerInterface $customer
    ): void {
        $workflow->can($customer, 'blacklisting')->willReturn(true);
        $workflow->apply($customer, 'blacklisting')->shouldBeCalled();
        $customerManager->persist($customer)->shouldBeCalled();
        $customerManager->flush()->shouldBeCalled();

        $this->changeStateOnBlacklisted($customer);
    }

    function it_does_not_change_state_if_cannot_apply_blacklisting(
        WorkflowInterface $workflow,
        ObjectManager $customerManager,
        CustomerInterface $customer
    ): void {
        $workflow->can($customer, 'blacklisting')->willReturn(false);
        $workflow->apply($customer, 'blacklisting')->shouldNotBeCalled();
        $customerManager->persist($customer)->shouldNotBeCalled();
        $customerManager->flush()->shouldNotBeCalled();

        $this->changeStateOnBlacklisted($customer);
    }
}
