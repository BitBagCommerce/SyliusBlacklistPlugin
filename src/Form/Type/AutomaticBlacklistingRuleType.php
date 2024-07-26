<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

final class AutomaticBlacklistingRuleType extends AbstractConfigurableAutomaticBlacklistingConfigurationElementType
{
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', AutomaticBlacklistingRuleChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.type',
                'attr' => [
                    'data-form-collection' => 'update',
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_rule';
    }
}
