<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class AutomaticBlacklistingConfigurationType extends AbstractResourceType
{
    /** @var array */
    private $attributeChoices;

    public function __construct(string $dataClass, array $attributeChoices, array $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);
        $this->attributeChoices = $attributeChoices;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.name',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.channels',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.ui.enabled',
            ])
            ->add('rules', AutomaticBlacklistingRuleCollectionType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.rules',
                'button_add_label' => 'sylius.form.promotion.add_rule',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_configuration';
    }
}
