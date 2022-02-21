<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker;

use BitBag\SyliusBlacklistPlugin\Checker\UserRoleChecker;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class UserRoleCheckerSpec extends ObjectBehavior
{
    public function let(TokenStorageInterface $tokenStorage): void
    {
        $this->beConstructedWith($tokenStorage);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UserRoleChecker::class);
    }

    public function it_returns_true_if_object_returned_from_storage_is_an_admin_user_interface(
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $token->getUser()->willReturn($adminUser);
        $tokenStorage->getToken()->willReturn($token);

        $this->isAdmin()->shouldReturn(true);
    }

    public function it_returns_false_if_object_returned_from_storage_is_not_an_admin_user_interface(
        TokenStorageInterface $tokenStorage,
        TokenInterface $token
    ): void {
        $token->getUser()->willReturn(new \stdClass());
        $tokenStorage->getToken()->willReturn($token);

        $this->isAdmin()->shouldReturn(false);
    }
}
