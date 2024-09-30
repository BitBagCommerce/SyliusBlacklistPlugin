<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use Sylius\Bundle\AdminBundle\Form\Type\AddButtonType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\PromotionBundle\Form\Type\PromotionRuleType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

final class AutomaticBlacklistingConfigurationType extends AbstractResourceType
{
    /** @var array */
    private $attributeChoices;

    public function __construct(
        string $dataClass,
        array $attributeChoices,
        array $validationGroups = [],
        private array $rules,
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
//            ->add('rules', AutomaticBlacklistingRuleCollectionType::class, [
//                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.rules',
//                'button_add_label' => 'sylius.form.promotion.add_rule',
//            ])
            ->add('rules', LiveCollectionType::class, [
                'entry_type' => AutomaticBlacklistingRuleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'button_add_type' => AddButtonType::class,
                'button_add_options' => [
                    'label' => 'sylius.ui.add_rule',
                    'types' => $this->rules,
                ],
                'button_delete_options' => [
                    'label' => false,
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_configuration';
    }
}
