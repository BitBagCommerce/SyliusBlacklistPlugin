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
use Sylius\Component\Customer\Model\CustomerGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class BlacklistingRuleType extends AbstractResourceType
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
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.name',
            ])
            ->add('attributes', ChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.attribute',
                'multiple' => true,
                'expanded' => true,
                'choices' => $this->attributeChoices

            ])
            ->add('permittedStrikes', NumberType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.permitted_strikes',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.channels',
            ])
            ->add('customerGroups', EntityType::class, [
                'class' => CustomerGroup::class,
                'multiple' => true,
                'expanded' => true,
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.customer_group',
            ])
            ->add('forUnassignedCustomers', CheckboxType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.for_unassigned_customers',
                'required' => false
            ])
            ->add('onlyForGuests', CheckboxType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.blacklisting_rule.only_for_guests',
                'required' => false
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.ui.enabled',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_blacklisting_rule';
    }
}
