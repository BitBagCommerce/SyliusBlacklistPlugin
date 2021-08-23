<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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

    function it_resolves_address_type_and_updates_fraud_suspicion(FraudSuspicionInterface $fraudSuspicion, OrderInterface $order, AddressInterface $address): void
    {
        $fraudSuspicion->getAddressType()->willReturn(FraudSuspicion::BILLING_ADDRESS_TYPE);
        $fraudSuspicion->getOrder()->willReturn($order);
        $order->getBillingAddress()->willReturn($address);
        $address->getFirstName()->willReturn('John');
        $address->getLastName()->willReturn('Doe');
        $address->getCompany()->willReturn('Google');
        $address->getCity()->willReturn('Warsaw');
        $address->getStreet()->willReturn('Groove Street');
        $address->getProvinceName()->willReturn('Mazowieckie');
        $address->getCountryCode()->willReturn('PL');
        $address->getPhoneNumber()->willReturn(null);

        $fraudSuspicion->getAddressType()->shouldBeCalled();
        $fraudSuspicion->getOrder()->shouldBeCalled();
        $order->getBillingAddress()->shouldBeCalled();
        $address->getFirstName()->shouldBeCalled();
        $address->getLastName()->shouldBeCalled();
        $address->getCompany()->shouldBeCalled();
        $address->getCity()->shouldBeCalled();
        $address->getStreet()->shouldBeCalled();
        $address->getProvinceName()->shouldBeCalled();
        $address->getCountryCode()->shouldBeCalled();
        $address->getPhoneNumber()->shouldBeCalled();
        $fraudSuspicion->setFirstName('John')->shouldBeCalled();
        $fraudSuspicion->setLastName('Doe')->shouldBeCalled();
        $fraudSuspicion->setCompany('Google')->shouldBeCalled();
        $fraudSuspicion->setCity('Warsaw')->shouldBeCalled();
        $fraudSuspicion->setStreet('Groove Street')->shouldBeCalled();
        $fraudSuspicion->setProvince('Mazowieckie')->shouldBeCalled();
        $fraudSuspicion->setCountry('PL')->shouldBeCalled();
        $fraudSuspicion->setPhoneNumber(null)->shouldBeCalled();

        $this->resolveAndUpdateFraudSuspicion($fraudSuspicion);
    }
}
