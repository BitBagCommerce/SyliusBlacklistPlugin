<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
