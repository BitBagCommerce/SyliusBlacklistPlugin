<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin;

use BitBag\SyliusBlacklistPlugin\DependencyInjection\Compiler\RegisterAutomaticBlacklistingRuleCheckersPass;
use BitBag\SyliusBlacklistPlugin\DependencyInjection\Compiler\RegisterBlacklistingRuleCheckersPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BitBagSyliusBlacklistPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterBlacklistingRuleCheckersPass());
        $container->addCompilerPass(new RegisterAutomaticBlacklistingRuleCheckersPass());
    }
}
