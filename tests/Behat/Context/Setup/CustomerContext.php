<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;

final class CustomerContext implements Context
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