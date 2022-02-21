<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SyliusBehatPolyfillCompilerPass implements CompilerPassInterface
{
    private const USER_API_CONTEXT_ID = 'sylius.api.context.user';

    private const USER_API_CONTEXT_CLASS = 'Sylius\Bundle\ApiBundle\Context\UserContextInterface';

    private const KERNEL_ENVIRONMENT_KEY = 'kernel.environment';

    private const TEST = 'test';

    public function process(ContainerBuilder $container)
    {
        /** @var string $environment */
        $environment = $container->getParameter(self::KERNEL_ENVIRONMENT_KEY);
        if (self::TEST !== $environment) {
            return;
        }

        if (!$container->hasDefinition(self::USER_API_CONTEXT_ID)) {
            $container->setAlias(self::USER_API_CONTEXT_ID, self::USER_API_CONTEXT_CLASS)->setPublic(true);
        }
    }
}
