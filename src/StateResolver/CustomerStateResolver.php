<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions;
use Doctrine\Persistence\ObjectManager;
use SM\Factory\FactoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

class CustomerStateResolver implements CustomerStateResolverInterface
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
