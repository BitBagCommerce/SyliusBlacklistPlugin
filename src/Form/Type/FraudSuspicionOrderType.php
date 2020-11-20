<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class FraudSuspicionOrderType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addressType', ChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.ui.address_type',
                'choices' => [
                    'sylius.ui.shipping_address' => FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE,
                    'sylius.ui.billing_address' => FraudSuspicionInterface::BILLING_ADDRESS_TYPE
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.fraud_suspicion.comment',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_fraud_suspicion';
    }
}
