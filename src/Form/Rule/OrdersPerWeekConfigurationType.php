<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Rule;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class OrdersPerWeekConfigurationType extends AbstractType
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
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_automatic_blacklisting_rule_orders_per_week_configuration';
    }
}
