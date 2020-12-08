<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Customer\IndexPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Customer\ShowPageInterface;
use Webmozart\Assert\Assert;

final class CustomerContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var ShowPageInterface */
    private $showPage;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        ShowPageInterface $showPage,
        CustomerRepositoryInterface $customerRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->showPage = $showPage;
        $this->customerRepository = $customerRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @When I go to the customer page
     */
    public function iGoToTheCustomerPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the show :email customer page
     */
    public function iGoToTheShowCustomerPage(string $email): void
    {
        $id = $this->customerRepository->findOneBy(['email' => $email])->getId();

        $this->showPage->open(['id' => $id]);
    }

    /**
     * @Then I should be notified that the customer has been successfully updated
     */
    public function iShouldBeNotifiedThatTheCustomerHasBeenUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Customer has been successfully updated.',
            NotificationType::success()
        );
    }

    /**
     * @Given I click :buttonName button
     */
    public function iClickButton(string $buttonName): void
    {
        $this->resolveCurrentPage()->clickButton($buttonName);
    }

    /**
     * @return IndexPageInterface|ShowPageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->showPage
        ]);
    }

    /**
     * @Then customer :email should be :fraudStatus
     */
    public function customerShouldBe(string $email, string $expectedFraudStatus): void
    {
        $customer = $this->customerRepository->findOneBy(['email' => $email]);

        $this->entityManager->refresh($customer);

        Assert::same($customer->getFraudStatus(), $expectedFraudStatus);
    }
}
