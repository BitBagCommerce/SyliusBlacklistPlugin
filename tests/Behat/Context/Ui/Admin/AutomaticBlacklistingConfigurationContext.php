<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use Sylius\Behat\NotificationType;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration\CreatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration\IndexPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration\UpdatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Service\RandomStringGeneratorInterface;
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

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }

    /**
     * @When I go to the create automatic blacklisting configuration page
     */
    public function iGoToTheCreateAutomaticBlacklistingConfigurationPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I name it :configurationName
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
        $this->createPage->selectAutocompleteRuleOption('Date modifier', $dateModifier);
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
