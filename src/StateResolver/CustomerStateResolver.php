<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions;
use Doctrine\Common\Persistence\ObjectManager;
use SM\Factory\FactoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class CustomerStateResolver
{
    /** @var FactoryInterface */
    private $stateMachineFactory;

    /** @var ObjectManager */
    private $productManager;

    public function __construct(FactoryInterface $stateMachineFactory, ObjectManager $customerManager)
    {
        $this->stateMachineFactory = $stateMachineFactory;
        $this->productManager = $customerManager;
    }

    public function changeStateOnBlacklisted(CustomerInterface $customer): void
    {
        $stateMachine = $this->stateMachineFactory->get($customer, CustomerTransitions::GRAPH);
        $transition = CustomerTransitions::TRANSITION_BLACKLISTING_PROCESS;

        if (!$stateMachine->can($transition)) {
            return;
        }

        $stateMachine->apply($transition);

        $this->productManager->persist($customer);
        $this->productManager->flush();
    }
}
