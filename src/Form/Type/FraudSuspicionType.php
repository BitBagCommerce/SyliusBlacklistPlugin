<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\Customer;

final class FraudSuspicionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
            ])
            ->add('company', TextType::class, [
                'required' => false
            ])
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('street', TextType::class)
            ->add('city', TextType::class)
            ->add('province', TextType::class, [
                'required' => false
            ])
            ->add('country', TextType::class)
            ->add('addressType', ChoiceType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.ui.address_type',
                'choices' => [
                    'sylius.ui.shipping_address' => FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE,
                    'sylius.ui.billing_address' => FraudSuspicionInterface::BILLING_ADDRESS_TYPE
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'bitbag_sylius_blacklist_plugin.form.fraud_suspicion.comment',
                'required' => false
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_fraud_suspicion';
    }
}
