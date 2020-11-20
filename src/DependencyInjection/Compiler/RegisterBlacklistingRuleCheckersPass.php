<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterBlacklistingRuleCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('bitbag_sylius_blacklist_plugin.registry_blacklisting_rule_checker') || !$container->has('bitbag_sylius_blacklist_plugin.form_registry.blacklisting_rule_checker')) {
            return;
        }

        $blacklistingRuleCheckerRegistry = $container->getDefinition('bitbag_sylius_blacklist_plugin.registry_blacklisting_rule_checker');
        $blacklistingRuleCheckerFormTypeRegistry = $container->getDefinition('bitbag_sylius_blacklist_plugin.form_registry.blacklisting_rule_checker');

        $blacklistingRuleAttributeChoices = [];
        foreach ($container->findTaggedServiceIds('bitbag_sylius_blacklist_plugin.blacklisting_rule_checker') as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (!isset($attribute['field-name'], $attribute['label'], $attribute['form_type'])) {
                    throw new \InvalidArgumentException('Tagged rule checker `' . $id . '` needs to have `field-name`, `form_type` and `label` attributes.');
                }

                $blacklistingRuleAttributeChoices[$attribute['label']] = $attribute['field-name'];
                $blacklistingRuleCheckerRegistry->addMethodCall('register', [$attribute['field-name'], new Reference($id)]);
                $blacklistingRuleCheckerFormTypeRegistry->addMethodCall('add', [$attribute['field-name'], 'default', $attribute['form_type']]);
            }
        }

        $container->setParameter('bitbag_sylius_blacklist_plugin.blacklisting_rule_attribute_choices', $blacklistingRuleAttributeChoices);
    }
}
