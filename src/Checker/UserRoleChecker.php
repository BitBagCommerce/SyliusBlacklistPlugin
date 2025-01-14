<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker;

use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class UserRoleChecker implements UserRoleCheckerInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage
    ) {}

    public function isAdmin(): bool
    {
        $token = $this->tokenStorage->getToken();
        if ($token === null) {
            return false;
        }

        $user = $token->getUser();

        return $user instanceof AdminUserInterface;
    }
}
