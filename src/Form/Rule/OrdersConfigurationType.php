<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Rule;

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
                    new NotBlank(['groups' => ['bit bag']]),
                    new Type(['type' => 'numeric', 'groups' => ['bit bag']]),
                ],
            ])
            ->add('date_modifier', ChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.date_modifier',
                'required' => true,
                'choices' => [
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_day' => '1 day',
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_week' => '1 week',
                    'bitbag_sylius_blacklist_plugin.form.automatic_blacklisting_rule.per_month' => '1 month',
                ]
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_rule_orders_per_week_configuration';
    }
}
