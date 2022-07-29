<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

final class AutomaticBlacklistingConfigurationType extends AbstractResourceType
{
    /** @var array */
    private $attributeChoices;

    public function __construct(
        string $dataClass,
        array $attributeChoices,
        array $validationGroups = []
    ) {
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
                'required' => false,
            ])
            ->add('addFraudSuspicion', CheckboxType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.ui.add_fraud_suspicion_row_after_exceed_limit',
                'required' => false,
            ])
            ->add('permittedFraudSuspicionsNumber', NumberType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.ui.permitted_fraud_suspicions_number',
                'required' => false,
                'constraints' => [
                    new GreaterThanOrEqual(['value' => 1, 'groups' => ['bitbag']]),
                ],
            ])
            ->add('permittedFraudSuspicionsTime', ChoiceType::class, [
                'label' => false,
                'empty_data' => null,
                'required' => false,
                'choices' => [
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_day' => AutomaticBlacklistingRuleInterface::PER_DAY,
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_week' => AutomaticBlacklistingRuleInterface::PER_WEEK,
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_month' => AutomaticBlacklistingRuleInterface::PER_MONTH,
                ],
                'placeholder' => 'bitbag_sylius_blacklist_plugin.ui.choose_time_range',
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
