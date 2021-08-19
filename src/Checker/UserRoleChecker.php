<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Checker;

use Sylius\Bundle\ApiBundle\Context\UserContextInterface;
use Sylius\Component\Core\Model\AdminUserInterface;

final class UserRoleChecker implements UserRoleCheckerInterface
{
    /** @var UserContextInterface */
    private $userContext;

    public function __construct(UserContextInterface $userContext)
    {
        $this->userContext = $userContext;
    }

    public function isAdmin(): bool
    {
        $user = $this->userContext->getUser();

        return $user instanceof AdminUserInterface;
    }
}
