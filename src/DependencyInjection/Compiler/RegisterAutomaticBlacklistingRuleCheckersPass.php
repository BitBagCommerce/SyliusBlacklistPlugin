<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
