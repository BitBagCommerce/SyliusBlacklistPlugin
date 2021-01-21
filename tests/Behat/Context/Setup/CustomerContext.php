<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;

class CustomerContext implements Context
{
    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var ObjectManager */
    private $customerManager;

    public function __construct(CustomerRepositoryInterface $customerRepository, ObjectManager $customerManager)
    {
        $this->customerRepository = $customerRepository;
        $this->customerManager = $customerManager;
    }

    /**
     * @Given the customer :email has a :fraudStatus fraud status
     */
    public function iHaveAFraudStatus(string $email, string $fraudStatus): void
    {
        $customer = $this->customerRepository->findOneBy(['email' => $email]);

        $customer->setFraudStatus($fraudStatus);

        $this->customerManager->persist($customer);
        $this->customerManager->flush();
    }
}