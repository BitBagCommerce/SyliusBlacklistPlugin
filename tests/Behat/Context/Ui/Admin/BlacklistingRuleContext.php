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
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule\CreatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule\IndexPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule\UpdatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

final class BlacklistingRuleContext implements Context
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

    /** @var RandomStringGeneratorInterface */
    private $randomStringGenerator;

    /** @var BlacklistingRuleRepositoryInterface */
    private $blacklistingRuleRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        RandomStringGeneratorInterface $randomStringGenerator,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
    }

    /**
     * @When I go to the blacklisting rule page
     */
    public function iGoToTheBlacklistingRulePage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the update :ruleName blacklisting rule page
     */
    public function iGoToTheUpdateBlockPage(string $ruleName): void
    {
        $id = $this->blacklistingRuleRepository->findOneBy(['name' => $ruleName])->getId();

        $this->updatePage->open(['id' => $id]);
    }

    /**
     * @When I go to the create blacklisting rule page
     */
    public function iGoToTheCreateImageBlacklistingRulePage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I fill "([^"]*)" fields with (\d+) (?:character|characters)$/
     */
    public function iFillFieldsWithCharacters(string $fields, int $length): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            $this->resolveCurrentPage()->fillField(trim($field), $this->randomStringGenerator->generate($length));
        }
    }

    /**
     * @When I fill the rule name with :name
     */
    public function iFillTheNameWith(string $name): void
    {
        $this->resolveCurrentPage()->fillName($name);
    }

    /**
     * @Given /^I select "([^"]*)" and "([^"]*)" as rule attributes$/
     */
    public function iSelectAndAsRuleAttributes($arg1, $arg2): void
    {
        $currentPage = $this->resolveCurrentPage();

        $currentPage->selectOption('Rule attributes', $arg1);
        $currentPage->selectOption('Rule attributes', $arg2);
    }

    /**
     * @When I fill the permittedStrikes with :permittedStrikes
     */
    public function iFillTheContentWith(string $permittedStrikes): void
    {
        $this->resolveCurrentPage()->fillField('Permitted strikes', $permittedStrikes);
    }

    /**
     * @Given /^I select "([^"]*)" as channels$/
     */
    public function iSelectAsChannels($arg1): void
    {
        $this->resolveCurrentPage()->checkField($arg1);
    }

    /**
     * @Given /^I select "([^"]*)" and "([^"]*)" as customer groups$/
     */
    public function iSelectAndAsCustomerGroups($arg1, $arg2): void
    {
        $currentPage = $this->resolveCurrentPage();

        $currentPage->selectOption('Customer groups', $arg1);
        $currentPage->selectOption('Customer groups', $arg2);
    }

    /**
     * @Given /^I check enabled$/
     */
    public function iCheckEnabled(): void
    {
        $this->resolveCurrentPage()->enable();
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
     * @When I disable it
     */
    public function iDisableIt(): void
    {
        $this->resolveCurrentPage()->disable();
    }

    /**
     * @Then I should be notified that the blacklisting rule has been created
     */
    public function iShouldBeNotifiedThatTheBlacklistingRuleHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Blacklisting rule has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the blacklisting rule has been deleted
     */
    public function iShouldBeNotifiedThatTheBlacklistingRuleHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Blacklisting rule has been successfully deleted.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the blacklisting rule has been successfully updated
     */
    public function iShouldBeNotifiedThatTheBlacklistingRuleHasBeenUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Blacklisting rule has been successfully updated.',
            NotificationType::success()
        );
    }

    /**
     * @Then blacklisting rule :name should be disabled
     */
    public function thisBlacklistingRuleShouldBeDisabled(string $name): void
    {
        Assert::true($this->resolveCurrentPage()->isBlacklistingRuleDisabled($name));
    }

    /**
     * @Then I should see empty list of blacklisting rules
     */
    public function iShouldSeeEmptyListOfBlacklistingRules(): void
    {
        $this->resolveCurrentPage()->isEmpty();
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatCannotBeBlank(string $fields): void
    {
        $fields = explode(', ', $fields);


        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                'The %s cannot be blank',
                $field
            )));
        }
    }

    /**
     * @Then I should be notified that :fields fields are too long
     */
    public function iShouldBeNotifiedThatFieldsAreTooLong(string $fields): void
    {
        $fields = explode(', ', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                'The %s is too long',
                $field
            )));
        }
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
     * @Given I delete this blacklisting rule
     */
    public function iDeleteThisBlacklistingRule(): void
    {
        $blacklistingRule = $this->sharedStorage->get('blacklistingRule');

        $this->indexPage->deleteBlacklistingRule($blacklistingRule->getName());
    }
}
