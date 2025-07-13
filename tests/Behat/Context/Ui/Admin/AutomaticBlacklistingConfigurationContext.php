<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
    private $indexPage;

    /** @var CreatePageInterface */
    private $createPage;

    /** @var UpdatePageInterface */
    private $updatePage;

    /** @var AutomaticBlacklistingConfigurationRepositoryInterface */
    private $automaticBlacklistingConfigurationRepository;

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
    public function iGoToUpdateConfigurationPage(string $configurationName): void
    {
        $automaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findOneBy(['name' => $configurationName]);

        $this->updatePage->open(['id' => $automaticBlacklistingConfiguration->getId()]);
    }

    /**
     * @When I delete a :configurationName automatic blacklisting configuration
     */
    public function iDeleteAPromotionAutomaticBlacklistingConfiguration(string $configurationName): void
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
    public function iSelectAsChannels($arg1): void
    {
        $this->resolveCurrentPage()->checkField($arg1);
    }

    /**
     * @Given I enable it
     */
    public function iEnableIt(): void
    {
        $this->resolveCurrentPage()->enable();
    }

    /**
     * @Given I add the :ruleType rule configured with count :count and :dateModifier as date modifier
     */
    public function iAddTheRuleConfiguredWithCountAndAsDateModifier(string $ruleType, string $count, string $dateModifier): void
    {
        $this->resolveCurrentPage()->addRule($ruleType);

        $this->resolveCurrentPage()->fillRuleOption('Count', $count);
        $this->resolveCurrentPage()->selectRuleOption('Date modifier', $dateModifier);
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
    public function promotionShouldNotExistInTheRegistry(string $configurationName): void
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
     * @Given I do not want to add fraud suspicion row after exceeding limit
     */
    public function iDoNotWantToAddFraudSuspicionRowAfterExceedingLimit()
    {
        $this->resolveCurrentPage()->uncheckField('Add fraud suspicion row after exceeding limit');
    }

    /**
     * @Given I want to add fraud suspicion row after exceeding limit
     */
    public function iWantToAddFraudSuspicionRowAfterExceedingLimit()
    {
        $this->resolveCurrentPage()->checkField('Add fraud suspicion row after exceeding limit');
    }

    /**
     * @Then I should be notified that I need to add settings to fraud suspicion section
     */
    public function iShouldBeNotifiedThatINeedToAddSettingsToFraudSuspicionSection()
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage('Permitted fraud suspicions number cannot be blank'));
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage('Permitted fraud suspicions time cannot be blank'));
    }

    /**
     * @Given I change last rule count with :count
     */
    public function iChangeLastRuleCountWith(string $count): void
    {
        $this->resolveCurrentPage()->fillRuleOption('Count', $count);
    }

    /**
     * @Given I complete permitted fraud suspicions number with :number
     */
    public function iCompletePermittedFraudSuspicionsNumberWith(string $permittedFraudSuspicionsNumber)
    {
        $this->resolveCurrentPage()->fillField('Permitted fraud suspicions number', $permittedFraudSuspicionsNumber);
    }

    /**
     * @Given I select :option as time range
     */
    public function iSelectAsPermittedFraudSuspicionsTime(string $option)
    {
        $selectTimeRangeId = 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_configuration_permittedFraudSuspicionsTime';
        $this->resolveCurrentPage()->selectOption($selectTimeRangeId, $option);
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
}
