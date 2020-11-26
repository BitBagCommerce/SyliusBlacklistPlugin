<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
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

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        RandomStringGeneratorInterface $randomStringGenerator
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->randomStringGenerator = $randomStringGenerator;
    }

    /**
     * @When I go to the blacklisting rule page
     */
    public function iGoToTheBlacklistingRulePage()
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create blacklisting rule page
     */
    public function iGoToTheCreateImageBlacklistingRulePage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I delete this blacklisting rule
     */
    public function iDeleteThisBlacklistingRule()
    {
        $blacklistingRule = $this->sharedStorage->get('blacklistingRule');

        $this->indexPage->deleteBlock($blacklistingRule->getId());
    }

    /**
     * @When I go to the update :id blacklisting rule page
     */
    public function iGoToTheUpdateBlockPage(string $id)
    {
        $this->updatePage->open(['id' => $id]);
    }

    /**
     * @When I want to edit this block
     */
    public function iWantToEditThisBlock()
    {
        $blacklistingRule = $this->sharedStorage->get('blacklistingRule');

        $this->updatePage->open(['id' => $blacklistingRule->getId()]);
    }

    /**
     * @When I fill :fields fields
     */
    public function iFillFields(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            $this->resolveCurrentPage()->fillField(trim($field), $this->randomStringGenerator->generate());
        }
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
     * @When I fill the permittedStrikes with :permittedStrikes
     */
    public function iFillTheContentWith(string $permittedStrikes): void
    {
        $this->resolveCurrentPage()->fillField('Permitted strikes', $permittedStrikes);
    }

    /**
     * @When I select :ruleAttribute[0], :ruleAttirbute[1] and :ruleAttirbute[2] as rule attributes
     */
    public function iSelectAsRuleAttributes(array $ruleAttributes): void
    {
        $currentPage = $this->resolveCurrentPage();
        foreach ($ruleAttributes as $ruleAttribute) {
            $currentPage->selectOption('Rule attributes', $ruleAttribute);
        }
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
     * @Then I should be notified that the blacklisting rule has been successfully updated
     */
    public function iShouldBeNotifiedThatTheBlacklistingRuleHasBeenSuccessfullyUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Blacklisting rule has been successfully updated.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the blacklisting rule has been successfully deleted
     */
    public function iShouldBeNotifiedThatTheBlacklistingRuleHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Blacklisting rule has been successfully deleted.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatCannotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s cannot be blank.',
                trim($field)
            )));
        }
    }

    /**
     * @Then I should be notified that :fields fields are too long
     */
    public function iShouldBeNotifiedThatFieldsAreTooLong(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s can not be longer than',
                trim($field)
            ), false));
        }
    }

    /**
     * @Then I should see empty list of blacklisting rules
     */
    public function iShouldSeeEmptyListOfBlocks(): void
    {
        $this->resolveCurrentPage()->isEmpty();
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
     * @Given /^I select "([^"]*)", "([^"]*)" and "([^"]*)" as rule attributes$/
     */
    public function iSelectAndAsRuleAttributes($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }
}
