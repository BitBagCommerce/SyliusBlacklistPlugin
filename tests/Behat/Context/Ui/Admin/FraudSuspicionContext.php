<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion\CreateFromOrderPage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion\CreateFromOrderPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion\UpdatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Order\ShowPageInterface;
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

    /** @var UpdatePageInterface */
    private UpdatePageInterface $updatePage;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var ShowPageInterface */
    private ShowPageInterface $orderShowPage;

    /** @var OrderRepositoryInterface */
    private OrderRepositoryInterface $orderRepository;

    /** @var FraudSuspicionRepositoryInterface */
    private FraudSuspicionRepositoryInterface $fraudSuspicionRepository;

    /** @var CreateFromOrderPageInterface */
    private CreateFromOrderPageInterface $createFromOrderPage;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        CreateFromOrderPageInterface $createFromOrderPage,
        UpdatePageInterface $updatePage,
        ShowPageInterface $orderShowPage,
        CustomerRepositoryInterface $customerRepository,
        OrderRepositoryInterface $orderRepository,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->createFromOrderPage = $createFromOrderPage;
        $this->updatePage = $updatePage;
        $this->orderShowPage = $orderShowPage;
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
    }

    /**
     * @When I go to the create fraud suspicion page
     */
    public function iGoToTheCreateImageFraudSuspicionPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I go to the update fraud suspicion with order number :orderNumber page
     */
    public function iGoToTheUpdateFraudSuspicionWithOrderNumberPage(string $orderNumber)
    {
        $fraudSuspicion = $this->fraudSuspicionRepository->findOneByOrderNumber($orderNumber);

        $this->updatePage->open(['id' => $fraudSuspicion->getId()]);
    }

    /**
     * @When I go to the order with number :orderNumber page
     */
    public function iGoToTheOrderWithNumberPage(string $orderNumber): void
    {
        $order = $this->orderRepository->findOneBy(['number' => $orderNumber]);

        $this->orderShowPage->open(['id' => $order->getId()]);
    }

    /**
     * @Then I fill the street with :street
     */
    public function iFillTheStreetWith(string $street)
    {
        $this->resolveCurrentPage()->fillStreet($street);
    }

    /**
     * @Then I fill the city with :city
     */
    public function iFillTheCityWith(string $city)
    {
        $this->resolveCurrentPage()->fillCity($city);
    }

    /**
     * @Then I fill all required fields basing on order :orderNumber address
     */
    public function iFillAllRequiredFieldsBasingOnOrderAddress(string $orderNumber)
    {
        $order = $this->orderRepository->findOneBy(['number' => $orderNumber]);

        $customerLastUsedAddress = $order->getBillingAddress();

        $this->resolveCurrentPage()
            ->selectOption('Customer', $order->getCustomer()->getEmail())
            ->fillField('Company', $customerLastUsedAddress->getCompany())
            ->fillField('Company', $customerLastUsedAddress->getCompany())
            ->fillField('First name', $customerLastUsedAddress->getFirstName())
            ->fillField('Last name', $customerLastUsedAddress->getLastName())
            ->fillField('Email', $order->getCustomer()->getEmail())
            ->fillField('Street', $customerLastUsedAddress->getStreet())
            ->fillField('City', $customerLastUsedAddress->getCity())
            ->fillField('Country', $customerLastUsedAddress->getCountryCode())
            ->selectOption('Address type', 'Billing address')
            ->fillField('Comment', 'Some comment for fraud suspicion');
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @When I update it
     */
    public function iUpdateIt(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then I select :addressType as address type
     */
    public function iSelectAsAddressType(string $addressType)
    {
        $this->resolveCurrentPage()->selectOption('Address type', $addressType);
    }

    /**
     * @Given I add comment :comment
     */
    public function iAddComment(string $comment)
    {
        $this->resolveCurrentPage()->fillField('Comment', $comment);
    }

    /**
     * @Given I click :buttonName button
     */
    public function iClickButton(string $buttonName)
    {
        $this->resolveCurrentPage()->clickButton($buttonName);
    }

    /**
     * @Then I should be notified that the fraud suspicion has been created
     */
    public function iShouldBeNotifiedThatTheFraudSuspicionHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Fraud suspicion has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the fraud suspicion has been successfully updated
     */
    public function iShouldBeNotifiedThatTheFraudSuspicionHasBeenUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Fraud suspicion has been successfully updated.',
            NotificationType::success()
        );
    }

    /**
     * @return IndexPageInterface|CreatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->createPage,
            $this->createFromOrderPage,
            $this->updatePage,
            $this->orderShowPage
        ]);
    }
}