<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */
declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Rule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRule;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class OrdersConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('count', IntegerType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.count',
                'constraints' => [
                    new NotBlank(['groups' => ['bitbag']]),
                    new Type(['type' => 'numeric', 'groups' => ['bitbag']]),
                ],
            ])
            ->add('date_modifier', ChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.date_modifier',
                'required' => true,
                'choices' => [
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_day' => AutomaticBlacklistingRuleInterface::PER_DAY,
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_week' => AutomaticBlacklistingRuleInterface::PER_WEEK,
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_month' => AutomaticBlacklistingRuleInterface::PER_MONTH,
                ]
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_rule_orders_configuration';
    }
}
