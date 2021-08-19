<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Form\Rule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

final class AutomaticBlacklistingRuleSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('count', IntegerType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.count',
                'constraints' => [
                    new NotBlank(['groups' => ['bitbag']]),
                    new Type(['type' => 'numeric', 'groups' => ['bitbag']]),
                    new Range(['min' => 1, 'groups' => ['bitbag']]),
                ],
            ])
            ->add('date_modifier', ChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.date_modifier',
                'required' => true,
                'choices' => [
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_day' => AutomaticBlacklistingRuleInterface::PER_DAY,
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_week' => AutomaticBlacklistingRuleInterface::PER_WEEK,
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_month' => AutomaticBlacklistingRuleInterface::PER_MONTH,
                ],
                'attr' => ['style' => 'margin-bottom: 10px;']
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_rule_settings';
    }
}
