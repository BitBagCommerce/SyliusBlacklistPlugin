<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\AddressTypeResolver;
use BitBag\SyliusBlacklistPlugin\Resolver\AddressTypeResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\OrderInterface;

final class AddressTypeResolverSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddressTypeResolver::class);
    }

    function it_implements_address_type_resolver_interface(): void
    {
        $this->shouldHaveType(AddressTypeResolverInterface::class);
    }

    function it_resolves_address_type_from_fraud_suspicion(FraudSuspicionInterface $fraudSuspicion, OrderInterface $order, AddressInterface $address): void
    {
        $fraudSuspicion->getAddressType()->willReturn(FraudSuspicion::BILLING_ADDRESS_TYPE);

        $fraudSuspicion->getOrder()->willReturn($order);
        $order->getBillingAddress()->willReturn($address);

        $this->resolve($fraudSuspicion);
    }

//    function it_resolves_address_type_and_updates_fraud_suspicion(FraudSuspicionInterface $fraudSuspicion, OrderInterface $order, AddressInterface $address): void
//    {
//        $fraudSuspicion->getAddressType()->willReturn(FraudSuspicion::BILLING_ADDRESS_TYPE);
//        $fraudSuspicion->getOrder()->willReturn($order);
//        $order->getBillingAddress()->willReturn($address);
//
//        $address->getFirstName()->willReturn('John');
//        $address->getLastName()->willReturn('Doe');
//        $address->getCompany()->willReturn('john_doe@example.com');
//        $address->getCity()->willReturn('Warsaw');
//        $address->getProvinceName()->willReturn('Mazowieckie');
//        $address->getCountryCode()->willReturn('PL');
//        $address->getPhoneNumber()->willReturn(null);
//
//        $fraudSuspicion->setFirstName('John');
//        $fraudSuspicion->setLastName('Doe');
//        $fraudSuspicion->setCompany('john_doe@example.com');
//        $fraudSuspicion->setCity('Warsaw');
//        $fraudSuspicion->setProvince('Mazowieckie');
//        $fraudSuspicion->setCountry('PL');
//        $fraudSuspicion->setPhoneNumber(null);
//
//        $this->resolveAndUpdateFraudSuspicion($fraudSuspicion);
//    }
}
