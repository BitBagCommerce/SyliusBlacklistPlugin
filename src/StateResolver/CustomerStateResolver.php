<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions;
use Doctrine\Common\Persistence\ObjectManager;
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
