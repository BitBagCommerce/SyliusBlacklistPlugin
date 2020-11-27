<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Customer\ShowPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion\IndexPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion\CreatePageInterface;

final class FraudSuspicionContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var CreatePageInterface */
    private $createPage;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @When I go to the create fraud suspicion page
     */
    public function iGoToTheCreateImageFraudSuspicionPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @Given I fill all required fields basing on customer :email address
     */
    public function iFillAllRequiredFieldsBasingOnCustomerAddress(string $email)
    {
        $customer = $this->customerRepository->findOneBy(['email' => $email]);

        $this->resolveCurrentPage()
            ->fillField('Customer id', strval($customer->getId()))
            ->fillField('Company', $customer->getBillingAddress()->getCompany())
            ->fillField('Company', $customer->getBillingAddress()->getCompany())
            ->fillField('First name', $customer->getBillingAddress()->getFirstName())
            ->fillField('Last name', $customer->getBillingAddress()->getLastName())
            ->fillField('Email', $customer->getEmail())
            ->fillField('Street', $customer->getBillingAddress()->getStreet())
            ->fillField('City', $customer->getBillingAddress()->getCity())
            ->fillField('Country', $customer->getBillingAddress()->getCountryCode())
            ->selectOption('AddressType', 'Billing address')
            ->fillField('Comment', 'Some comment for fraud suspicion');
    }

    /**
     * @return IndexPageInterface|CreatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->createPage
        ]);
    }
}
