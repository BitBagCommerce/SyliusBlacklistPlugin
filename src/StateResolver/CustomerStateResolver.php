<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

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
