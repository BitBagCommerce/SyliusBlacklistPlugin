<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Shop\Checkout\AddressPageInterface;
use Webmozart\Assert\Assert;

final class CheckoutContext implements Context
{
    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var AddressPageInterface */
    private $addressPage;

    public function __construct(CurrentPageResolverInterface $currentPageResolver, AddressPageInterface $addressPage)
    {
        $this->currentPageResolver = $currentPageResolver;
        $this->addressPage = $addressPage;
    }

    /**
     * @Then I should be notified that something went wrong
     */
    public function iShouldBeNotifiedThatSomethingWentWrong(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf('Something went wrong. You cannot place the order.')));
    }

    /**
     * @return AddressPageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->addressPage
        ]);
    }

    /**
     * @Given /^I should be at the checkout addressing step$/
     */
    public function iShouldBeAtTheCheckoutAddressingStep(): void
    {
        Assert::same($this->resolveCurrentPage(), $this->addressPage);
    }
}
