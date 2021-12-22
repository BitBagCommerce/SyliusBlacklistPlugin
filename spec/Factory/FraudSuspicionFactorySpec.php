<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactory;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class FraudSuspicionFactorySpec extends ObjectBehavior
{
    function let(FactoryInterface $decoratedFactory)
    {
        $this->beConstructedWith($decoratedFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionFactory::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionFactoryInterface::class);
    }

    function it_creates_empty_fraud_suspicion_object(
        FactoryInterface $decoratedFactory,
        FraudSuspicionInterface $fraudSuspicion
    ): void
    {
        $decoratedFactory->createNew()->willReturn($fraudSuspicion);

        $this->createNew()->shouldReturn($fraudSuspicion);

        $this->createNew()->getId()->shouldReturn(null);
    }
    function it_creates_fraud_suspicion_objet_from_order(
        OrderInterface $order,
        CustomerInterface $customer,
        AddressInterface $address,
        FactoryInterface $decoratedFactory,
        FraudSuspicionInterface $fraudSuspicion
    ): void
    {
        $order->getCustomer()->willReturn($customer);
        $order->getCustomerIp()->willReturn('192.168.10.12');
        $order->getBillingAddress()->willReturn($address);
        $address->getFirstName()->willReturn('John');
        $address->getLastName()->willReturn('Doe');
        $customer->getEmail()->willReturn('john_doe@example.com');
        $address->getCountryCode()->willReturn('PL');
        $address->getProvinceName()->willReturn(null);
        $address->getCompany()->willReturn(null);
        $address->getPostcode()->willReturn('00-000');
        $address->getCity()->willReturn('Warsaw');
        $address->getStreet()->willReturn('Aleje Jerozolimskie 23');

        $order->getCustomer()->shouldBeCalled();
        $order->getCustomerIp()->shouldBeCalled();
        $order->getBillingAddress()->shouldBeCalled();
        $address->getFirstName()->shouldBeCalled();
        $address->getLastName()->shouldBeCalled();
        $customer->getEmail()->shouldBeCalled();
        $address->getCountryCode()->shouldBeCalled();
        $address->getProvinceName()->shouldBeCalled();
        $address->getCompany()->shouldBeCalled();
        $address->getPostcode()->shouldBeCalled();
        $address->getCity()->shouldBeCalled();
        $address->getStreet()->shouldBeCalled();

        $decoratedFactory->createNew()->willReturn($fraudSuspicion);


        $this->createForOrder($order)->shouldReturn($fraudSuspicion);
    }
}
