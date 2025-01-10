<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use Symfony\Component\Workflow\WorkflowInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Customer\Model\CustomerInterface;

class CustomerStateResolver implements CustomerStateResolverInterface
{
    private WorkflowInterface $workflow;
    private ObjectManager $customerManager;

    public function __construct(WorkflowInterface $workflow, ObjectManager $customerManager)
    {
        $this->workflow = $workflow;
        $this->customerManager = $customerManager;
    }

    public function changeStateOnBlacklisted(CustomerInterface $customer): void
    {
        if (!$this->workflow->can($customer, 'blacklisting')) {
            return;
        }

        $this->workflow->apply($customer, 'blacklisting');

        $this->customerManager->persist($customer);
        $this->customerManager->flush();
    }
}
