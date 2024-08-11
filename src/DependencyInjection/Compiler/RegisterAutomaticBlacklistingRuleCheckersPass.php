<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterAutomaticBlacklistingRuleCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (
            !$container->has('bitbag_sylius_blacklist_plugin.registry_automatic_blacklisting_rule_checker') ||
            !$container->has('bitbag_sylius_blacklist_plugin.form_registry.automatic_blacklisting_rule_checker')
        ) {
            return;
        }

        $automaticBlacklistingRuleCheckerRegistry = $container->getDefinition('bitbag_sylius_blacklist_plugin.registry_automatic_blacklisting_rule_checker');
        $automaticBlacklistingRuleCheckerFormTypeRegistry = $container->getDefinition('bitbag_sylius_blacklist_plugin.form_registry.automatic_blacklisting_rule_checker');

        $automaticBlacklistingRuleCheckerTypeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('bitbag_sylius_blacklist_plugin.automatic_blacklisting_rule_checker') as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (!isset($attribute['type'], $attribute['label'], $attribute['form_type'])) {
                    throw new \InvalidArgumentException('Tagged rule checker `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
                }

                $automaticBlacklistingRuleCheckerTypeToLabelMap[$attribute['type']] = $attribute['label'];
                $automaticBlacklistingRuleCheckerRegistry->addMethodCall('register', [$attribute['type'], new Reference($id)]);
                $automaticBlacklistingRuleCheckerFormTypeRegistry->addMethodCall('add', [$attribute['type'], 'default', $attribute['form_type']]);
            }
        }

        $container->setParameter('bitbag.sylius_blacklist_plugin.automatic_blacklisting_rules', $automaticBlacklistingRuleCheckerTypeToLabelMap);
    }
}
