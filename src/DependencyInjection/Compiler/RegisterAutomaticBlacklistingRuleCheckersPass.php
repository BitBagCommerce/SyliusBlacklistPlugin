<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterAutomaticBlacklistingRuleCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('bitbag_sylius_blacklist_plugin.registry_automatic_blacklisting_rule_checker') ||
            !$container->has('bitbag_sylius_blacklist_plugin.form_registry.automatic_blacklisting_rule_checker')) {
            return;
        }

        $promotionRuleCheckerRegistry = $container->getDefinition('bitbag_sylius_blacklist_plugin.registry_automatic_blacklisting_rule_checker');
        $promotionRuleCheckerFormTypeRegistry = $container->getDefinition('bitbag_sylius_blacklist_plugin.form_registry.automatic_blacklisting_rule_checker');

        $promotionRuleCheckerTypeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('bitbag_sylius_blacklist_plugin.automatic_blacklisting_rule_checker') as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (!isset($attribute['type'], $attribute['label'], $attribute['form_type'])) {
                    throw new \InvalidArgumentException('Tagged rule checker `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
                }

                $promotionRuleCheckerTypeToLabelMap[$attribute['type']] = $attribute['label'];
                $promotionRuleCheckerRegistry->addMethodCall('register', [$attribute['type'], new Reference($id)]);
                $promotionRuleCheckerFormTypeRegistry->addMethodCall('add', [$attribute['type'], 'default', $attribute['form_type']]);
            }
        }

        $container->setParameter('bit_bag.sylius_blacklist_plugin.automatic_blacklisting_rules', $promotionRuleCheckerTypeToLabelMap);
    }
}
