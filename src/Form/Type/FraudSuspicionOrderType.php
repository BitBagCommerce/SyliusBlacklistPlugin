<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Type;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\AddressTypeResolver;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class FraudSuspicionOrderType extends AbstractResourceType
{
    /** @var AddressTypeResolver */
    private $addressTypeResolver;

    public function __construct(string $dataClass, AddressTypeResolver $addressTypeResolver, array $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);

        $this->addressTypeResolver = $addressTypeResolver;
    }

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
                'required' => false
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event): void {
                $this->addressTypeResolver->resolveAndUpdateFraudSuspicion($event->getData());
            })
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_blacklist_plugin_fraud_suspicion';
    }
}
