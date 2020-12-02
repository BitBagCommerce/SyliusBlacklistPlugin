<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use Sylius\Behat\NotificationType;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration\CreatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration\IndexPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class AutomaticBlacklistingConfigurationContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var IndexPageInterface */
    private IndexPageInterface $indexPage;

    /** @var CreatePageInterface */
    private CreatePageInterface $createPage;

    /** @var UpdatePageInterface */
    private UpdatePageInterface $updatePage;

    /** @var AutomaticBlacklistingConfigurationRepositoryInterface */
    private AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->automaticBlacklistingConfigurationRepository = $automaticBlacklistingConfigurationRepository;
    }

    /**
     * @When I go to the create automatic blacklisting configuration page
     */
    public function iGoToTheCreateAutomaticBlacklistingConfigurationPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I go to update configuration :configurationName page
     */
    public function iGoToUpdateConfigurationPage(string $configurationName)
    {
        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findOneBy(['name' => $configurationName]);

        $this->updatePage->open(['id' => $automaticBlacklistingConfiguration->getId()]);
    }

    /**
     * @When I delete a :configurationName automatic blacklisting configuration
     */
    public function iDeleteAPromotionAutomaticBlacklistingConfiguration(string $configurationName)
    {
        $this->indexPage->open();

        $this->resolveCurrentPage()->deleteAutomaticBlacklistingConfiguration($configurationName);
    }

    /**
     * @When I name it :configurationName
     * @Then I fill configuration name with :configurationName
     */
    public function iNameIt(string $configurationName): void
    {
        $this->resolveCurrentPage()->fillName($configurationName);
    }

    /**
     * @Given /^I select "([^"]*)" as channels$/
     */
    public function iSelectAsChannels($arg1)
    {
        $this->resolveCurrentPage()->checkField($arg1);
    }

    /**
     * @Given I enable it
     */
    public function iEnableIt()
    {
        $this->resolveCurrentPage()->enable();
    }

    /**
     * @Given I add the :ruleType rule configured with count :count and :dateModifier as date modifier
     */
    public function iAddTheRuleConfiguredWithCountAndAsDateModifier(string $ruleType, string $count, string $dateModifier)
    {
        $this->resolveCurrentPage()->addRule($ruleType);

        $this->createPage->fillRuleOption('Count', $count);
        $this->createPage->selectRuleOption('Date modifier', $dateModifier);
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
     * @When I try to update it
     */
    public function iUpdateIt(): void
    {
        $this->updatePage->update();
    }

    /**
     * @Then I should be notified that the automatic blacklisting configuration has been created
     */
    public function iShouldBeNotifiedThatTheAutomaticBlacklistingConfigurationHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Automatic blacklisting configuration has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the automatic blacklisting configuration has been successfully deleted
     */
    public function iShouldBeNotifiedThatTheAutomaticBlacklistingConfigurationSuccessfullyHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Automatic blacklisting configuration has been successfully deleted.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the automatic blacklisting configuration has been successfully updated
     */
    public function iShouldBeNotifiedThatTheAutomaticBlacklistingConfigurationSuccessfullyHasBeenUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Automatic blacklisting configuration has been successfully updated.',
            NotificationType::success()
        );
    }

    /**
     * @Then :configurationName should no longer exist in the automatic blacklisting configuration registry
     */
    public function promotionShouldNotExistInTheRegistry(string $configurationName)
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $configurationName]));
    }

    /**
     * @Then the :configurationName should appear in the registry
     */
    public function thePromotionShouldAppearInTheRegistry(string $configurationName): void
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $configurationName]));
    }

    /**
     * @return IndexPageInterface|CreatePageInterface|UpdatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->createPage,
            $this->updatePage,
        ]);
    }

    /**
     * @Given I change last rule count with :count
     */
    public function iChangeLastRuleCountWith(string $count)
    {
        $this->resolveCurrentPage()->fillRuleOption('Count', $count);
    }
}